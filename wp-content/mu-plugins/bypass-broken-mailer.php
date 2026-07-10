<?php
/**
 * Plugin Name: Asynchronous Mail Queue (Safe)
 * Description: Queues WordPress emails using Action Scheduler to prevent checkout hangs, sending them in the background using the native wp_mail.
 * Version: 1.2
 * Author: Antigravity
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Global flag to prevent infinite loops when sending from the queue
$GLOBALS['sending_async_email_now'] = false;

// Intercept emails before they are sent
add_filter( 'pre_wp_mail', 'async_mail_queue_intercept', 10, 2 );

function async_mail_queue_intercept( $return_val, $atts ) {
	// If we are currently sending an email from the background task, let WordPress send it normally
	if ( ! empty( $GLOBALS['sending_async_email_now'] ) ) {
		return null; // Return null so WordPress continues sending
	}

	$to          = $atts['to'];
	$subject     = $atts['subject'];
	$message     = $atts['message'];
	$headers     = $atts['headers'];
	$attachments = $atts['attachments'];

	// Log that we are queueing
	$log_dir = WP_CONTENT_DIR . '/uploads';
	if ( ! is_dir( $log_dir ) ) {
		@mkdir( $log_dir, 0755, true );
	}
	@file_put_contents( $log_dir . '/sent-emails.log', "[" . date('Y-m-d H:i:s') . "] Queueing email to: " . (is_array($to) ? implode(',', $to) : $to) . " (Subject: $subject)\n", FILE_APPEND );

	// Queue the email
	$queue = get_option( 'async_email_queue', array() );
	if ( ! is_array( $queue ) ) {
		$queue = array();
	}
	
	$email_id = uniqid( 'email_', true );
	$queue[ $email_id ] = array(
		'to'          => $to,
		'subject'     => $subject,
		'message'     => $message,
		'headers'     => $headers,
		'attachments' => $attachments,
	);
	
	update_option( 'async_email_queue', $queue, false );
	
	// Schedule background action via Action Scheduler
	if ( function_exists( 'as_enqueue_async_action' ) ) {
		as_enqueue_async_action( 'send_async_queued_email', array( 'email_id' => $email_id ) );
	} else {
		wp_schedule_single_event( time(), 'send_async_queued_email', array( 'email_id' => $email_id ) );
	}
	
	// Return true to WordPress to abort the synchronous send and return success
	return true;
}

// Background handler action
add_action( 'send_async_queued_email', 'process_async_queued_email' );
function process_async_queued_email( $email_id ) {
	$queue = get_option( 'async_email_queue', array() );
	if ( ! isset( $queue[ $email_id ] ) ) {
		return;
	}

	$email = $queue[ $email_id ];
	
	// Set the flag to true so pre_wp_mail doesn't intercept it
	$GLOBALS['sending_async_email_now'] = true;
	
	$sent = wp_mail(
		$email['to'],
		$email['subject'],
		$email['message'],
		$email['headers'],
		$email['attachments']
	);
	
	$GLOBALS['sending_async_email_now'] = false;

	$log_dir = WP_CONTENT_DIR . '/uploads';
	if ( $sent ) {
		@file_put_contents( $log_dir . '/sent-emails.log', "[" . date('Y-m-d H:i:s') . "] Real send SUCCESS to: " . (is_array($email['to']) ? implode(',', $email['to']) : $email['to']) . "\n", FILE_APPEND );
		unset( $queue[ $email_id ] );
		update_option( 'async_email_queue', $queue, false );
	} else {
		@file_put_contents( $log_dir . '/sent-emails.log', "[" . date('Y-m-d H:i:s') . "] Real send FAILED to: " . (is_array($email['to']) ? implode(',', $email['to']) : $email['to']) . "\n", FILE_APPEND );
	}
}
