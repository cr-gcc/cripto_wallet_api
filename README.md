<div align="center">

# 🪙 CryptoWallet API

**API RESTful para gestión de portafolios de criptomonedas, seguimiento de precios en tiempo real y sistema de alertas automatizadas.**

> ⚠️ **En desarrollo activo** — Demo funcional en construcción. Las funcionalidades principales están operativas; se continúan agregando endpoints y mejoras de forma incremental.

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![Passport](https://img.shields.io/badge/OAuth2-Laravel%20Passport-orange?style=for-the-badge)](https://laravel.com/docs/passport)
[![CoinGecko](https://img.shields.io/badge/API-CoinGecko-8DC63F?style=for-the-badge)](https://www.coingecko.com/api)
[![SQLite](https://img.shields.io/badge/Base%20de%20datos-SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://www.sqlite.org/)
[![License](https://img.shields.io/badge/Licencia-MIT-blue?style=for-the-badge)](LICENSE)

</div>

---

## 📖 Descripción general

CryptoWallet API es un servicio REST backend construido con **Laravel 12** que permite a los usuarios gestionar su portafolio de criptomonedas. Se integra con la **API pública de CoinGecko** para obtener precios de mercado en tiempo real e implementa un sistema de alertas automatizadas que notifica al usuario cuando un activo cruza un umbral de precio definido.

El proyecto está diseñado como un **demo funcional** que demuestra buenas prácticas de backend: autenticación OAuth2, arquitectura por capas de servicios, trabajos en segundo plano con colas, y notificaciones persistidas en base de datos.

---

## ✨ Funcionalidades principales

| Funcionalidad | Descripción |
|---|---|
| 🔐 **Autenticación OAuth2** | Autenticación segura con tokens Bearer mediante Laravel Passport |
| 📊 **Gestión de portafolio** | Administración de wallets y vista consolidada del portafolio |
| 💱 **Historial de transacciones** | Registro de compras/ventas por activo |
| 💰 **Precios en tiempo real** | Precios actualizados de CoinGecko (BTC, ETH, SOL) con caché en servidor |
| 🔔 **Alertas de precio** | Creación de alertas condicionales (`>` / `<`) por moneda con CRUD completo |
| ⚙️ **Procesamiento asíncrono** | Jobs en cola (`CheckPriceAlerts`) que verifican precios y disparan notificaciones automáticamente |
| 📬 **Notificaciones internas** | Notificaciones persistidas en base de datos con soporte de marcar como leídas |
| 🗄️ **Caché inteligente** | Capa de caché de 60 segundos sobre llamadas a API externos para evitar rate limiting |

---

## 🏗️ Arquitectura

El proyecto sigue una **arquitectura por capas de servicios** que separa responsabilidades entre controladores, servicios y modelos.

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/V1/              # Controladores versionados
│   │       ├── Auth/            # Registro, Login, Me, Logout
│   │       ├── Crypto/          # Endpoint de precios en vivo
│   │       ├── Portfolio/       # Wallet, Transacciones, Resumen de portafolio
│   │       └── Alerts/          # CRUD de alertas de precio
│   └── Requests/                # Clases de validación (Form Requests)
│
├── Services/                    # Capa de lógica de negocio (desacoplada del HTTP)
│   ├── Auth/
│   ├── Crypto/                  # Integración con CoinGecko + caché
│   ├── Portfolio/               # Servicios de Wallet, Transacciones y Portafolio
│   ├── Alerts/                  # Ciclo de vida de alertas de precio
│   └── Notification/
│
├── Jobs/
│   └── CheckPriceAlerts.php     # Job en cola: consulta precios y dispara notificaciones
│
├── Notifications/
│   └── PriceAlertNotification.php
│
└── Models/
    ├── User.php                 # HasApiTokens (Passport), Notifiable
    ├── Wallet.php
    ├── Transaction.php
    └── PriceAlert.php
```

### Principios de diseño

- **Versionado de API** — Todas las rutas llevan el prefijo `/api/v1/` para evolución compatible hacia adelante.
- **Patrón Service Layer** — Controladores delgados; toda la lógica de negocio vive en clases Service dedicadas.
- **Excepciones de dominio** — `PriceAlertCreationException`, `PriceAlertUpdateException` para manejo limpio de errores.
- **Automatización por colas** — El motor de alertas corre como un job `ShouldQueue`, completamente desacoplado del ciclo HTTP.
- **Caché proactiva** — `Cache::remember()` envuelve las llamadas a APIs externas, haciendo el sistema resiliente a caídas de terceros y rate limits.

---

## 🔌 Integración con API de terceros

### CoinGecko API (Tier gratuito)

| Detalle | Valor |
|---|---|
| Proveedor | [CoinGecko](https://www.coingecko.com/api/documentation) |
| Endpoint utilizado | `GET /simple/price` |
| Activos consultados | `bitcoin`, `ethereum`, `solana` |
| Moneda base | USD |
| TTL de caché | **60 segundos** (en servidor, evita rate limiting) |
| Timeout | 10 segundos con fallback graceful |

La integración está encapsulada en `CryptoService`, que gestiona la comunicación HTTP, el logging y la administración del caché. Este aislamiento hace trivial cambiar de proveedor (p. ej., CoinMarketCap, Binance API) sin tocar ninguna otra parte del sistema.

---

## 🛣️ Endpoints de la API

### Rutas públicas
```
GET  /api/v1/version
POST /api/v1/auth/register
POST /api/v1/auth/login
GET  /api/v1/crypto/prices
```

### Rutas protegidas (requieren Bearer Token)
```
GET  /api/v1/auth/me
GET  /api/v1/auth/logout

GET  /api/v1/portfolio

GET  /api/v1/wallet
POST /api/v1/wallet
DEL  /api/v1/wallet/{id}

GET  /api/v1/transactions
POST /api/v1/transactions

GET  /api/v1/alerts
POST /api/v1/alerts
PUT  /api/v1/alerts/{alert}
DEL  /api/v1/alerts/{alert}

GET  /api/v1/notifications
GET  /api/v1/notifications/mark-as-read
```

---

## 🗃️ Esquema de base de datos

```
users               → id, name, email, password, timestamps
wallets             → id, user_id (FK), symbol, balance, timestamps
transactions        → id, user_id (FK), type, symbol, amount, price, timestamps
price_alerts        → id, user_id (FK), symbol, condition (</>), target_price, triggered, timestamps
notifications       → id, type, notifiable_type, notifiable_id, data, read_at, timestamps
jobs                → Tabla de trabajos en cola de Laravel (procesamiento asíncrono)
cache               → Tabla de caché de Laravel
```

---

## 🔧 Stack tecnológico

| Capa | Tecnología |
|---|---|
| **Runtime** | PHP 8.2+ |
| **Framework** | Laravel 12.x |
| **Autenticación** | Laravel Passport (OAuth2 / Bearer Token) |
| **Base de datos** | SQLite (desarrollo) — portable y sin configuración |
| **Driver de colas** | Cola basada en base de datos (`QUEUE_CONNECTION=database`) |
| **Driver de caché** | Caché en base de datos (`CACHE_STORE=database`) |
| **API externa** | CoinGecko REST API |
| **Cliente HTTP** | Laravel HTTP Client (wrapper de Guzzle) |
| **Notificaciones** | Laravel Notifications (canal database) |
| **Testing** | PHPUnit 11 |
| **Herramientas de desarrollo** | Laravel Pail (visor de logs), Laravel Pint (estilo de código), Laravel Sail |
| **Assets frontend** | Vite (bundler, para integración futura de frontend) |

---

## 🚀 Instalación y uso

### Requisitos previos

- PHP 8.2+
- Composer
- Node.js & npm

### Instalación

```bash
# Clonar el repositorio
git clone https://github.com/tu-usuario/cripto_api.git
cd cripto_api

# Instalar dependencias y configurar el proyecto en un solo comando
composer run setup
```

El script `setup` ejecuta automáticamente:
1. `composer install`
2. Creación del archivo `.env` a partir de `.env.example`
3. Generación de la clave de aplicación (`php artisan key:generate`)
4. Migraciones de base de datos (`php artisan migrate`)
5. `npm install` + `npm run build`

### Servidor de desarrollo

```bash
composer run dev
```

Esto inicia de forma concurrente:
- 🖥️ **Servidor Laravel** (`php artisan serve`)
- ⚙️ **Worker de colas** (`php artisan queue:listen`)
- 📋 **Visor de logs** (`php artisan pail`)
- ⚡ **Vite** (`npm run dev`)

### Ejecutar pruebas

```bash
composer run test
```

---

## ⚡ Sistema de alertas — Cómo funciona

El motor de alertas de precio demuestra un flujo de trabajo **event-driven basado en colas**:

```
1. El usuario crea una alerta via POST /api/v1/alerts
   └─ { symbol: "bitcoin", condition: ">", target_price: 70000 }

2. El job CheckPriceAlerts corre en segundo plano (queue:listen)
   └─ Consulta precios en vivo desde CoinGecko (via CryptoService + Caché)
   └─ Evalúa cada alerta no disparada contra el precio actual del mercado

3. Si la condición se cumple:
   └─ alert.triggered = true  (evita re-disparo)
   └─ PriceAlertNotification es enviada al usuario
   └─ La notificación se persiste en la tabla `notifications`

4. El usuario consulta sus notificaciones via GET /api/v1/notifications
   └─ Las marca como leídas via GET /api/v1/notifications/mark-as-read
```

---

## 📋 Variables de entorno

| Variable | Descripción | Valor por defecto |
|---|---|---|
| `APP_NAME` | Nombre de la aplicación | `Laravel` |
| `APP_ENV` | Entorno de ejecución | `local` |
| `DB_CONNECTION` | Driver de base de datos | `sqlite` |
| `QUEUE_CONNECTION` | Driver de colas | `database` |
| `CACHE_STORE` | Driver de caché | `database` |
| `LOG_LEVEL` | Verbosidad de logs | `debug` |

> La API pública de CoinGecko **no requiere API key** para el endpoint `/simple/price` utilizado en este proyecto.

---

## 🗺️ Roadmap

> El API está en evolución activa. Las adiciones planeadas incluyen:

- [ ] Endpoint de refresco de token
- [ ] Soporte para más criptomonedas (lista configurable)
- [ ] Integración con el scheduler de Laravel para verificación periódica de alertas (`php artisan schedule:run`)
- [ ] Analítica expandida de portafolio (cálculo de P&L, distribución porcentual por activo)
- [ ] Documentación Swagger / OpenAPI
- [ ] Docker + `docker-compose.yml` para entorno completamente contenedorizado
- [ ] Rate limiting por usuario en endpoints sensibles

---

## 👨‍💻 Autor

Desarrollado con ❤️ como demostración de patrones modernos de desarrollo de APIs con Laravel.

---

<div align="center">
<sub>PHP 8.2 · Laravel 12 · OAuth2 · CoinGecko · Queue Jobs · REST API</sub>
</div>
