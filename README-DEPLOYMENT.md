# 🚀 Deployment Guide - KP Penelitian Dosen

Panduan lengkap untuk deploy aplikasi menggunakan Docker ke VPS.

## 📋 Prerequisites

- Docker & Docker Compose terinstall di VPS
- Git (optional, untuk clone repository)
- Domain yang sudah diarahkan ke IP VPS (optional, untuk SSL)

---

## 🏃 Quick Start (Local Development)

```bash
# 1. Copy environment file
cp .env.example .env

# 2. Edit .env sesuai kebutuhan
# nano .env

# 3. Jalankan Docker containers
docker-compose up -d --build

# 4. Akses aplikasi
# App: http://localhost:8080
# phpMyAdmin: http://localhost:8081
```

---

## 🖥️ Deploy ke VPS

### Step 1: Upload Project ke VPS

```bash
# Option A: Clone dari Git
git clone https://github.com/username/KP-Penelitian-Dosen.git
cd KP-Penelitian-Dosen

# Option B: SCP dari local
scp -r ./KP-Penelitian-Dosen user@your-vps-ip:/var/www/
```

### Step 2: Setup Environment

```bash
# Copy dan edit environment file
cp .env.example .env
nano .env
```

**Contoh konfigurasi production:**
```env
DB_HOST=db
DB_USER=root
DB_PASS=your-strong-password-here
DB_NAME=sister

APP_NAME="KP Penelitian Dosen"
BASE_URL=https://yourdomain.com/

GOOGLE_CLIENT_ID=your-production-client-id
GOOGLE_CLIENT_SECRET=your-production-secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

### Step 3: Build dan Jalankan

```bash
# Build dan jalankan containers
docker-compose up -d --build

# Cek status containers
docker-compose ps

# Lihat logs jika ada masalah
docker-compose logs -f app
```

### Step 4: Setup SSL dengan Nginx Reverse Proxy (Optional)

Jika ingin menggunakan HTTPS, install Nginx di host VPS:

```bash
sudo apt update
sudo apt install nginx certbot python3-certbot-nginx

# Buat konfigurasi Nginx
sudo nano /etc/nginx/sites-available/kp-penelitian
```

**Nginx config:**
```nginx
server {
    listen 80;
    server_name yourdomain.com;

    location / {
        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/kp-penelitian /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Generate SSL certificate
sudo certbot --nginx -d yourdomain.com
```

---

## 🔧 Useful Commands

```bash
# Restart containers
docker-compose restart

# Stop containers
docker-compose down

# Stop dan hapus volumes (termasuk database)
docker-compose down -v

# Rebuild tanpa cache
docker-compose build --no-cache

# Masuk ke container app
docker-compose exec app bash

# Masuk ke MySQL
docker-compose exec db mysql -u root -p

# Lihat logs
docker-compose logs -f
```

---

## 🗄️ Database

Database akan otomatis diinisialisasi saat pertama kali `docker-compose up` dengan schema dari `database/schema.sql`.

### Backup Database

```bash
# Backup
docker-compose exec db mysqldump -u root -p sister > backup.sql

# Restore
docker-compose exec -T db mysql -u root -p sister < backup.sql
```

---

## 🔄 CI/CD dengan GitHub Actions

### Setup Secrets di GitHub

1. Buka repository di GitHub
2. Ke **Settings** → **Secrets and variables** → **Actions**
3. Tambahkan secrets berikut:

| Secret Name | Deskripsi | Contoh |
|-------------|-----------|--------|
| `VPS_HOST` | IP atau domain VPS | `103.xxx.xxx.xxx` |
| `VPS_USERNAME` | Username SSH | `root` atau `ubuntu` |
| `VPS_SSH_KEY` | Private SSH key | (isi full private key) |
| `VPS_PORT` | Port SSH | `22` |
| `VPS_PROJECT_PATH` | Path project di VPS | `/var/www/kp-penelitian-dosen` |
| `DB_USER` | Username database | `root` |
| `DB_PASS` | Password database | `your-strong-password` |
| `DB_NAME` | Nama database | `kp-penelitian-dosen` |
| `APP_NAME` | Nama aplikasi | `KP Penelitian Dosen` |
| `BASE_URL` | URL aplikasi | `https://yourdomain.com/` |
| `GOOGLE_CLIENT_ID` | Google OAuth Client ID | `xxx.apps.googleusercontent.com` |
| `GOOGLE_CLIENT_SECRET` | Google OAuth Secret | `GOCSPX-xxx` |
| `GOOGLE_REDIRECT_URI` | Google OAuth Callback | `https://yourdomain.com/auth/google/callback` |

### Generate SSH Key untuk Deployment

```bash
# Di local machine, generate key khusus untuk deploy
ssh-keygen -t ed25519 -C "github-actions-deploy" -f ~/.ssh/github_deploy_key

# Copy public key ke VPS
ssh-copy-id -i ~/.ssh/github_deploy_key.pub user@your-vps-ip

# Isi VPS_SSH_KEY secret dengan isi dari:
cat ~/.ssh/github_deploy_key
```

### Cara Kerja

1. Push ke branch `main` atau `master` → otomatis deploy
2. Atau trigger manual via **Actions** → **Deploy to VPS** → **Run workflow**

### Setup Awal di VPS

```bash
# Clone repository pertama kali
cd /var/www
git clone https://github.com/username/KP-Penelitian-Dosen.git
cd KP-Penelitian-Dosen

# Setup Docker (jika belum)
docker-compose up -d --build
```

---

## ⚠️ Troubleshooting

### Container tidak bisa start
```bash
# Cek logs
docker-compose logs app

# Kemungkinan masalah:
# - Port 8080/8081/3306 sudah digunakan
# - Permission issues
```

### Database connection error
```bash
# Pastikan container db sudah healthy
docker-compose ps

# Tunggu beberapa saat, MySQL butuh waktu untuk initialize
docker-compose logs db
```

### Permission denied
```bash
# Fix permissions
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
```

---

## 📁 File Structure

```
├── Dockerfile              # PHP + Apache image config
├── docker-compose.yml      # Multi-container orchestration
├── apache-config.conf      # Apache VirtualHost config
├── .env.example           # Environment template
├── .env                   # Environment (tidak di-commit)
├── .dockerignore          # Files to exclude from build
├── database/
│   └── schema.sql         # Database initialization script
├── app/                   # Application code
├── config/                # Configuration files
├── public/                # Web root (document root)
└── routes/                # Route definitions
```
