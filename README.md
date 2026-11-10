# Substation Asset Monitoring System (SAMS)

My Final Year Project for a Bachelor of Computer Science (Software Engineering) at Universiti Tenaga Nasional, built for a pilot with a national utility company. SAMS is a Laravel web application for monitoring substation assets. It records temperature and partial discharge readings for sensors installed in substation panels and compartments, raises warning and critical alerts, pushes those alerts to users in real time, and tracks each alert through a maintenance workflow from assignment to admin review. It also produces PDF reports for a chosen substation and date range.

**About the sensor data in this repository:** the readings are produced by scheduled dummy-data Artisan commands that run every 5 minutes, for demo and pilot purposes. The repository does not contain an integration with physical sensors. Readings can also be imported from Excel files through the Dataset screen.

Author: Muhammad Zulfitri Hakeem ([github.com/Zulfit](https://github.com/Zulfit))

## Tech stack

- **Backend:** Laravel 11, PHP 8.2
- **Database:** MySQL (some analytics queries use MySQL functions such as `MINUTE()`)
- **Auth:** Laravel Breeze (session login, registration, email verification, password reset)
- **Real-time:** Pusher broadcasting with Laravel Echo
- **Reports and imports:** `barryvdh/laravel-dompdf` (PDF reports), `maatwebsite/excel` (Excel dataset import)
- **Notifications:** Laravel Mail, the Telegram Bot API (over Laravel's HTTP client), and Stream Chat for user-to-user chat
- **Frontend:** Blade templates, Tailwind CSS, Alpine.js, Chart.js, Vite

## Key backend features

- **Asset hierarchy.** CRUD for substations, assets and sensors. Each sensor is linked to a substation, panel and compartment, and sensors can be added one at a time or in bulk.
- **Sensor readings.**
  - Temperature readings store the red, yellow and blue phase temperatures, max, min, the difference and the variance percentage. The alert level is `warn` when the difference is at least 0.8 and `critical` when it is at least 1.
  - Partial discharge readings store band ratios, EPPC values and an indicator.
- **Scheduled data commands.** `app/Console/Kernel.php` schedules `insert:dummy-sensor-temp` and `insert:dummy-sensor-pd` every five minutes. These generate readings for each sensor and keep an existing warning or critical state going until it is handled. Separate commands force warning or critical data for testing.
- **Alerts.**
  - Warning and critical readings create or update an entry in `error_logs`.
  - Each alert broadcasts a `SensorAlertTriggered` event on the public `sensor-alerts` channel (shown as a toast in the browser) and a notification event on the public `notification-channel`.
  - Alerts can also send a Telegram message to an admin group.
- **Maintenance workflow.** An admin assigns an error log to a staff member (status `New`, Telegram messages to the admin and staff groups). The staff member acknowledges it (`Acknowledge`) and submits a report (`Review`). The admin then completes it or sends it back with a query, and updates the sensor status.
- **Analytics and dashboard.** The dashboard has panel and compartment lookups by substation, plus temperature and partial discharge series over selectable periods. The analytics screen has a sensor table and chart data grouped by alert level.
- **PDF reports.** For a substation and date range, the report finds the maximum temperature difference and partial discharge indicator per sensor, along with error log statistics. It renders a PDF with DomPDF, stores it, and makes it available to download.
- **Dataset import.** Upload an Excel file for a sensor, and its rows are inserted as readings.
- **User management.** Admins create staff accounts with per-screen permissions stored as JSON (for example `dashboard_access` or `report_access`). Each new staff member gets a welcome email. Each module runs `checkAccessOrAbort` for that screen on every action (list, create, show, edit, update, delete and the module's extra endpoints), not only the list page. Asset routes require a signed-in user, but the app does not define an asset screen permission, so they are not checked against `user_management`.

## Project structure

```
app/
  Console/Commands/     dummy sensor data generators (scheduled in Console/Kernel.php)
  Events/               SensorAlertTriggered, NotificationEvent (broadcast)
  Http/Controllers/     Dashboard, Analytics, Substation, Asset, Sensor, Dataset,
                        ErrorLog, Report, UserManagement, Chat, Profile, Auth/*
  Imports/              DatasetImport (Excel)
  Mail/                 NewStaffRegistration
  Models/               Substation, Panels, Compartments, Asset, Sensor,
                        SensorTemperature, SensorPartialDischarge, ErrorLog,
                        Report, Dataset, UserManagement, User
  Notifications/        SensorAlertNotification (mail and Telegram)
database/
  migrations/           schema (15 migrations)
  seeders/              users, permissions, substations, panels, compartments,
                        sensors and sample readings
resources/views/        Blade screens per module, PDF report template, emails
routes/web.php          application routes
routes/auth.php         Breeze authentication routes
```

## Data model

| Table | Purpose |
|---|---|
| `users` | Accounts, including `position` (Admin, Manager or Staff in the seed data) |
| `user_management` | Per-user screen permissions (JSON) |
| `substations` | Name, location, date |
| `panels`, `compartments` | Panel and compartment names, referenced by sensors |
| `assets` | Name, type, substation, date, status |
| `sensors` | Name, substation, panel, compartment, measurement type, date, status |
| `sensor_temperature` | Three phase temperatures, max, min, difference, variance %, `alert_triggered` (`normal`, `warn`, `critical`) |
| `sensor_partial_discharge` | LFB, MFB and HFB ratios, EPPC values, indicator, `alert_triggered` (`normal`, `critical`) |
| `error_logs` | Polymorphic link to the triggering reading, state, threshold, severity, assignee (`pic`), assigned by, description, status, staff report, completion time, admin review, review time |
| `reports` | Substation, date range, generated by, stored file |
| `datasets` | Uploaded file, measurement type, sensor |

## Routes

This is a server-rendered application. Routes return Blade views or JSON for the dashboard and chart scripts. The main routes are listed below. Resource routes follow Laravel's standard index, create, store, show, edit, update and destroy actions.

Application pages sit behind the `auth` middleware. Guests are redirected to `/login`. Login, registration, password reset, the `/` redirect and the framework health check `/up` stay public. There is no webhook route. Alert broadcasting uses public Pusher channels, so clients do not call `/broadcasting/auth`. The scheduler is Artisan-only and is not affected by these web middleware groups.

The dashboard routes also use the `verified` middleware. The `User` model does not implement `MustVerifyEmail`, so that middleware currently allows any signed-in user. Email verification is not enforced until that contract is added.

Screen permissions are the same JSON check the list pages already used (`full`, `view`, `create`, `edit` or `delete` on that screen's key). A signed-in user without that screen permission receives 403 on the module's other actions as well.

| Method | Path | Access | Purpose |
|---|---|---|---|
| GET | `/` | Public | Redirect to login |
| GET | `/up` | Public | Laravel health check |
| GET/POST | `/login`, `/register`, `/forgot-password`, `/reset-password` | Guest | Breeze authentication |
| GET | `/dashboard` | Signed in, `verified` middleware; `dashboard_access` | Monitoring dashboard |
| POST | `/dashboard/stats-by-period` | Same as the dashboard | Dashboard statistics for a period (JSON) |
| GET | `/dashboard/panels/{substationId}`, `/dashboard/compartments/{panelId}` | Same as the dashboard | Location lookups (JSON) |
| POST | `/dashboard/sensor-temperature`, `/dashboard/sensor-partial-discharge` | Same as the dashboard | Reading series for charts (JSON) |
| GET | `/analytics`, `/sensor-table`, `/sensor-chart` | Signed in; `analytics_access` on every action | Analytics screen and data |
| Resource | `/substation`, `/sensor` | Signed in; screen permission on every action | Asset hierarchy CRUD |
| Resource | `/asset` | Signed in (no asset screen permission is defined) | Asset CRUD |
| GET/POST | `/bulk-create`, `/bulk-store` | Signed in; `sensor_access` | Bulk sensor creation |
| Resource | `/dataset` | Signed in; `dataset_access` on every action | Excel dataset upload |
| Resource | `/error-log` | Signed in; `error_log_access` on every action | Alert list, filters and workflow actions (update with `action` = assign, acknowledge, review, complete, quiry) |
| GET | `/error-log/assign/{id}` | Signed in; `error_log_access` | Assignment screen with readings since the alert |
| Resource | `/report` | Signed in; `report_access` on every action | Generate and list PDF reports |
| GET | `/reports/download/{id}` | Signed in; `report_access` | Download a stored report |
| Resource | `/user_management` | Signed in; `user_management_access` on every action | Staff accounts and permissions |
| GET | `/chat/token`, `/chat/token/header`, `/chat/user/{userId}` | Signed in | Stream Chat tokens and chat screen |
| GET/PATCH/DELETE | `/profile` | Signed in | Profile management |
| GET | `/about` | Signed in | Project about page |
| POST | `/clear-toast` | Signed in | Clears the session alert toast |

## Getting started

### Requirements

PHP 8.2+, Composer, Node.js and npm, and MySQL. Optional services: a Pusher app (real-time alerts), a Stream Chat app (chat), Telegram bots and groups (Telegram notifications) and an SMTP server (emails).

### Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

`.env.example` is already set up for this app (MySQL, Pusher, Stream, Telegram and mail). Fill in the blanks. No real secrets belong in the example file. `config/broadcasting.php` reads `BROADCAST_DRIVER`. Laravel 11's default skeleton name `BROADCAST_CONNECTION` is not what this project reads.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sams
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

STREAM_API_KEY=
STREAM_API_SECRET=

TELEGRAM_BOT_TOKEN=
GROUP_ADMIN_BOT_TOKEN=
GROUP_ADMIN_CHAT_ID=
GROUP_STAFF_CHAT_ID=
TELEGRAM_STAFF_GROUP_INVITE=
TELEGRAM_ADMIN_GROUP_INVITE=

SEED_USER_PASSWORD=password
```

`TELEGRAM_STAFF_GROUP_INVITE` and `TELEGRAM_ADMIN_GROUP_INVITE` are the group links included in the new-staff email. Leave them empty to send the email without a real invite. Configure the `MAIL_*` settings to send real emails. The example uses the `log` mailer.

```bash
php artisan migrate --seed   # schema and seed data
composer run dev             # php artisan serve, queue listener, log viewer and Vite together
```

In a second terminal, run the scheduler so the dummy readings are generated every five minutes:

```bash
php artisan schedule:work
```

To force a warning or critical alert while testing:

```bash
php artisan insert:dummy-warn {sensor_id?}
php artisan insert:dummy-critical {sensor_id?}
php artisan insert:dummy-critical-sensor-pd {sensorId}
```

`database/seeders/UserSeeder.php` creates example accounts. The password is `SEED_USER_PASSWORD`, which defaults to `password` for a local demo. Change that value before seeding anything that is not a private demo. The user factory used by the automated tests hashes the same demo password `password`, because the Breeze tests sign in with it. Staff accounts created later from User Management are still given that same default password, and the welcome email says so. Change that before any deployment that is not a private demo.

| Email | Name | Position | Email verified |
|---|---|---|---|
| `admin@example.com` | Example Admin | Admin | yes |
| `manager@example.com` | Example Manager | Manager | yes |
| `staff@example.com` | Example Staff | Staff | yes |
| `staff.pending@example.com` | Example Staff Pending | Staff | no |
| `manager.pending@example.com` | Example Manager Pending | Manager | no |

Seeded substation, panel and sensor names are demo catalogue data for the monitoring screens.

## Testing

The `tests/` folder contains the standard Laravel Breeze feature tests (authentication, registration, email verification, password reset and update, profile), a guest-access check, and the default example tests. `phpunit.xml` runs them on SQLite in memory so they do not touch the MySQL database. There are no tests yet for the monitoring features. Those screens use MySQL functions and need MySQL outside the test suite.

```bash
php artisan test
```
