# Campaign Mailer - Docker shortcuts
# Usage: make <target>

.PHONY: help up down stop restart ps logs build sh artisan composer npm test migrate fresh db redis mailpit

# نمایش لیست دستورها
help:
	@echo "Campaign Mailer - Makefile targets:"
	@echo ""
	@echo "  make up          - بالا آوردن همه‌ی سرویس‌ها"
	@echo "  make down        - متوقف کردن و حذف containerها"
	@echo "  make stop        - متوقف کردن موقت"
	@echo "  make restart     - ری‌استارت همه"
	@echo "  make ps          - وضعیت سرویس‌ها"
	@echo "  make logs        - لاگ‌های app"
	@echo "  make build       - ساخت image"
	@echo "  make sh          - ورود به shell کانتینر app"
	@echo "  make artisan ... - اجرای artisan (مثال: make artisan migrate)"
	@echo "  make composer ... - اجرای composer (مثال: make composer require xxx)"
	@echo "  make npm ...     - اجرای npm (مثال: make npm run build)"
	@echo "  make test        - اجرای تست‌ها"
	@echo "  make migrate     - اجرای migrationها"
	@echo "  make fresh       - پاک کردن دیتابیس و migration از صفر"

# بالا آوردن همه‌ی سرویس‌ها
up:
	docker compose up -d

# متوقف کردن و حذف containerها (volumeها می‌مونن)
down:
	docker compose down

# متوقف کردن موقت
stop:
	docker compose stop

# ری‌استارت همه
restart:
	docker compose restart

# وضعیت سرویس‌ها
ps:
	docker compose ps

# لاگ‌های app
logs:
	docker compose logs -f app

# ساخت image
build:
	docker compose build app

# ورود به shell کانتینر app
sh:
	docker compose exec app sh

# اجرای artisan (مثال: make artisan migrate)
artisan:
	docker compose exec app php artisan $(cmd)

# اجرای composer (مثال: make composer require filament/filament)
composer:
	docker compose exec app composer $(cmd)

# اجرای npm (مثال: make npm run build)
npm:
	docker compose exec app npm $(cmd)

# اجرای تست‌ها
test:
	docker compose exec app php artisan test

# اجرای migrationها
migrate:
	docker compose exec app php artisan migrate

# پاک کردن دیتابیس و اجرای migrationها از صفر
fresh:
	docker compose exec app php artisan migrate:fresh
