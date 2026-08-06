import os
import ftplib

FTP_HOST = "erudis.pt"
FTP_USER = "ftpprestig"
FTP_PASS = "qJpKz##5QdP"
REMOTE_ROOT = "public"

files_to_deploy = [
    ("facebook7g96kl39amnis4d919wimbbjaz09zq.html", "facebook7g96kl39amnis4d919wimbbjaz09zq.html"),
    ("7g96kl39amnis4d919wimbbjaz09zq.html", "7g96kl39amnis4d919wimbbjaz09zq.html"),
    ("wp-content/mu-plugins/multidomain-store.php", "wp-content/mu-plugins/multidomain-store.php"),


    ("wp-content/themes/prestige-child/functions.php", "wp-content/themes/prestige-child/functions.php"),
    ("wp-content/themes/prestige-child/style.css", "wp-content/themes/prestige-child/style.css"),
    ("wp-content/themes/prestige-child/twistshake.css", "wp-content/themes/prestige-child/twistshake.css"),
    ("wp-content/themes/prestige-child/header.php", "wp-content/themes/prestige-child/header.php"),
    ("wp-content/themes/prestige-child/header-twistshake.php", "wp-content/themes/prestige-child/header-twistshake.php"),
    ("wp-content/themes/prestige-child/footer-twistshake.php", "wp-content/themes/prestige-child/footer-twistshake.php"),
    ("wp-content/themes/prestige-child/footer.php", "wp-content/themes/prestige-child/footer.php"),
    ("wp-content/themes/prestige-child/front-page-twistshake.php", "wp-content/themes/prestige-child/front-page-twistshake.php"),
]

def make_dirs(ftp, remote_dir):
    parts = remote_dir.split('/')
    current = ""
    for part in parts:
        if not part: continue
        current = f"{current}/{part}" if current else part
        try:
            ftp.mkd(current)
        except:
            pass

def main():
    print("Connecting to FTP for deployment...")
    ftp = ftplib.FTP(FTP_HOST)
    ftp.login(FTP_USER, FTP_PASS)
    
    for local_rel, remote_rel in files_to_deploy:
        local_path = os.path.abspath(local_rel)
        remote_path = f"{REMOTE_ROOT}/{remote_rel}"
        
        remote_dir = os.path.dirname(remote_path)
        make_dirs(ftp, remote_dir)
        
        print(f"Uploading {local_rel} -> {remote_path}...")
        with open(local_path, 'rb') as f:
            ftp.storbinary(f'STOR {remote_path}', f)
        print(f"SUCCESS: {local_rel}")

    ftp.quit()
    print("Deployment to production complete!")

if __name__ == '__main__':
    main()
