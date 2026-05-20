# Настройка Storage в Laravel на сервере Plesk

## Контекст

Сервер: Plesk + nginx (реверс-прокси) → Apache (порт 7081).  
Проблема: файлы из `storage/app/public` возвращают **403 Forbidden**.  
Причина: Apache блокирует симлинк `public/storage` с ошибкой `AH00037: Symbolic link not allowed`.

---

## Пошаговое решение

### 1. Создать симлинк storage

```bash
cd /var/www/vhosts/hseipaa.kz/ДОМЕН
php artisan storage:link
```

### 2. Выставить права на папки

Пользователь на этом сервере — `hseipaa.kz`, группа — `psaserv`.

```bash
chown -R hseipaa.kz:psaserv storage bootstrap/cache public/storage
chmod -R 775 storage bootstrap/cache public/storage
```

> Определить пользователя можно командой:
> ```bash
> ls -la /var/www/vhosts/hseipaa.kz/
> ```
> Смотреть на владельца папок домена.

### 3. Создать файлы кастомных директив Apache

Plesk позволяет добавлять директивы в два файла (не трогать авто-генерируемый конфиг):

```bash
cat > /var/www/vhosts/system/ДОМЕН/conf/vhost_ssl.conf << 'EOF'
Alias /storage /var/www/vhosts/hseipaa.kz/ДОМЕН/storage/app/public
<Directory "/var/www/vhosts/hseipaa.kz/ДОМЕН/storage/app/public">
        Options FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
EOF

cat > /var/www/vhosts/system/ДОМЕН/conf/vhost.conf << 'EOF'
Alias /storage /var/www/vhosts/hseipaa.kz/ДОМЕН/storage/app/public
<Directory "/var/www/vhosts/hseipaa.kz/ДОМЕН/storage/app/public">
        Options FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
EOF
```

> Заменить `ДОМЕН` на имя домена, например `site.hseipaa.kz`.

### 4. Пересгенерировать конфиг Apache (ключевой шаг)

Без этого шага Plesk не добавит строку `Include` в авто-генерируемый конфиг, и директивы из `vhost_ssl.conf` не будут применяться.

```bash
/usr/local/psa/admin/bin/httpdmng --reconfigure-domain ДОМЕН
```

Проверить, что `Include` появился:

```bash
grep -n "Include\|Alias /storage" /etc/apache2/plesk.conf.d/vhosts/ДОМЕН.conf
```

Должны появиться строки:
```
Include "/var/www/vhosts/system/ДОМЕН/conf/vhost_ssl.conf"
Include "/var/www/vhosts/system/ДОМЕН/conf/vhost.conf"
```

### 5. Перезапустить Apache

```bash
service apache2 restart
```

---

## Настройка .env на сервере

При переносе проекта с локальной машины `.env` нужно обновить:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ваш-домен.kz

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=имя_базы
DB_USERNAME=пользователь
DB_PASSWORD=пароль
```

> Локальный `DB_HOST=MariaDB-11.7` (OSPanel) не работает на сервере — заменить на `127.0.0.1`.

После изменения `.env`:

```bash
php artisan config:clear
php artisan cache:clear
php artisan migrate --force
```

---

## Сборка фронтенда

```bash
npm install
npm run build
```

---

## Диагностика ошибок

| Ошибка | Причина | Решение |
|--------|---------|---------|
| `403 Forbidden` на `/storage/...` | Apache блокирует симлинк | Шаги 3–5 выше |
| `AH00037: Symbolic link not allowed` | Нет `FollowSymLinks` для папки | `vhost_ssl.conf` + `httpdmng` |
| `Access denied for user@localhost` | MySQL: пользователь создан без прав на `localhost` | `GRANT ALL PRIVILEGES ON db.* TO 'user'@'localhost' IDENTIFIED BY 'pass'; FLUSH PRIVILEGES;` |
| `tempnam(): file created in system's temporary directory` | PHP-FPM не может писать в storage | `chown -R hseipaa.kz:psaserv storage` |
| `slim-select` not found при `npm run build` | `node_modules` не установлены | `npm install` перед `npm run build` |
