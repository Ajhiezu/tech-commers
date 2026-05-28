# TechCommers — Laravel E-Commerce Marketplace: Implementation Plan

## Project Summary
Building a full-stack production-grade e-commerce marketplace (Shopee/Tokopedia-like) in Laravel 12. The project has a solid foundation (migrations, enums, basic auth) but is ~15% complete. Everything above the database layer needs to be built.

---

## Current State Audit

| Layer | Status | Notes |
|---|---|---|
| Laravel 12 + Filament v5 | ✅ Installed | Composer deps OK |
| Database Migrations (34 tables) | ✅ Done | All tables defined |
| PHP Enums (6) | ✅ Done | OrderStatus, PaymentStatus, etc. |
| Auth (Breeze) | ✅ Done | Login, Register, Password reset |
| Models | ⚠️ Shells Only | No relationships, fillable, casts |
| Seller Module | ⚠️ Partial | Dashboard, basic product/order CRUD, no wallet |
| Filament Admin | ⚠️ Empty dirs | Resources exist as directories only |
| Buyer Module | ❌ Missing | No controllers, views, routes |
| Homepage | ❌ Default | Still Laravel welcome page |
| Cart & Checkout | ❌ Missing | — |
| Payment (Midtrans) | ❌ Missing | — |
| Shipping (RajaOngkir) | ❌ Missing | — |
| Services Layer | ❌ Missing | — |
| Jobs/Events/Notifications | ❌ Missing | — |
| Seeders & Factories | ❌ Missing | Only default seeder |
| Tests | ❌ Missing | — |

---

## Implementation Phases

### Phase 1 — Models & Foundation (Core)
All Eloquent models with relationships, fillable, casts, scopes. AppServiceProvider helpers.

**Files to create/modify:**
- `app/Models/` — All 31 models (full relationships + fillable + casts)
- `app/Traits/HasSlug.php`, `HasAuditLog.php`, `HasCurrency.php`
- `app/Observers/OrderObserver.php`, `ProductObserver.php`
- `app/Providers/AppServiceProvider.php` — Register observers, helpers
- `config/app.php` — locale=id, timezone=Asia/Jakarta
- `helpers.php` — `formatRupiah()`, `formatDate()`, `formatWeight()`

---

### Phase 2 — Seeders, Factories & Dummy Data
Generate all test data so the app is immediately usable.

**Files:**
- `database/seeders/RolePermissionSeeder.php`
- `database/seeders/UserSeeder.php` — 1 admin, 5 sellers, 20 buyers
- `database/seeders/CategorySeeder.php` — 10 categories + subcategories
- `database/seeders/StoreSeeder.php` — 5 active stores
- `database/seeders/ProductSeeder.php` — 50 products with images
- `database/seeders/OrderSeeder.php` — 100 orders various statuses
- `database/seeders/ReviewSeeder.php`
- `database/seeders/VoucherSeeder.php`
- `database/seeders/FlashSaleSeeder.php`
- `database/seeders/PlatformSettingSeeder.php`
- `database/seeders/DatabaseSeeder.php` — Orchestrate all seeders
- `database/factories/` — All model factories

---

### Phase 3 — Services Layer
Business logic isolated in service classes.

**Files:**
- `app/Services/CartService.php`
- `app/Services/CheckoutService.php`
- `app/Services/OrderService.php`
- `app/Services/PaymentService.php` (Midtrans + dummy fallback)
- `app/Services/CommissionService.php`
- `app/Services/StockService.php`
- `app/Services/WalletService.php`
- `app/Services/ShippingService.php` (RajaOngkir + dummy fallback)
- `app/Services/ProductService.php`
- `app/DTOs/OrderDTO.php`, `ProductDTO.php`, `PaymentDTO.php`
- `app/Actions/Order/CreateOrderAction.php`, `CancelOrderAction.php`, `CompleteOrderAction.php`
- `app/Actions/Payment/ProcessPaymentAction.php`
- `app/Actions/Stock/DeductStockAction.php`

---

### Phase 4 — Jobs, Events, Notifications
Async processing for all heavy operations.

**Files:**
- `app/Events/OrderPlaced.php`, `PaymentReceived.php`, `OrderStatusUpdated.php`, `StockDepleted.php`
- `app/Listeners/` — Event listeners
- `app/Jobs/SendOrderConfirmationEmail.php`, `ProcessPaymentNotification.php`, `UpdateProductStockJob.php`, `GenerateSellerReport.php`
- `app/Notifications/OrderPlacedNotification.php`, `OrderStatusChangedNotification.php`, `WithdrawalApprovedNotification.php`
- `app/Mail/` — OrderConfirmationMail, OrderStatusUpdatedMail, StoreApprovedMail, etc.

---

### Phase 5 — Policies & Middleware
Authorization and route protection.

**Files:**
- `app/Policies/ProductPolicy.php`, `OrderPolicy.php`, `StorePolicy.php`
- `app/Http/Middleware/EnsureRole.php`
- `app/Http/Middleware/PreventBannedUser.php`
- `app/Http/Middleware/TrackRecentlyViewed.php`
- `bootstrap/app.php` — Register middleware aliases

---

### Phase 6 — Filament Admin Panel (Super Admin)
Complete Filament v5 resources for super admin.

**Files:**
- `app/Filament/Resources/Users/UserResource.php` — Full CRUD + ban/suspend
- `app/Filament/Resources/Stores/StoreResource.php` — Approval workflow
- `app/Filament/Resources/Products/ProductResource.php` — Monitoring + takedown
- `app/Filament/Resources/Orders/OrderResource.php` — Full order management
- `app/Filament/Resources/Categories/CategoryResource.php`
- `app/Filament/Resources/Withdrawals/WithdrawalResource.php`
- `app/Filament/Resources/Vouchers/VoucherResource.php`
- `app/Filament/Resources/PlatformSettings/PlatformSettingResource.php`
- `app/Filament/Pages/Dashboard.php` — Analytics dashboard with charts
- `app/Filament/Widgets/` — Revenue, orders, users stat widgets

---

### Phase 7 — Seller Module (Complete)
Full seller dashboard with all features.

**Controllers:**
- `SellerDashboardController` (analytics)
- `SellerProductController` (CRUD + variants + images)
- `SellerOrderController` (status management)
- `SellerWalletController` (balance + withdrawal)
- `SellerStoreController` (profile edit)
- `SellerVoucherController`
- `SellerFlashSaleController`
- `SellerAnalyticsController`
- `SellerOnboardingController` (existing, enhance)

**Views (resources/views/seller/):**
- `layouts/seller.blade.php` — Professional sidebar layout
- `dashboard.blade.php` — Revenue charts, stats
- `products/` — index, create, edit (with variant management)
- `orders/` — index, show (with status update)
- `wallet/` — index, withdraw modal
- `store/` — edit
- `vouchers/` — CRUD
- `flash-sales/` — CRUD with countdown

---

### Phase 8 — Buyer Module (Full)
Complete buyer-facing marketplace.

**Controllers:**
- `HomeController` — Homepage with all sections
- `ProductController` — Listing + detail
- `StoreController` — Store page
- `CategoryController` — Category browsing
- `SearchController` — Full-text search
- `CartController` — Add/remove/update
- `CheckoutController` — Multi-step checkout
- `OrderController` (Buyer) — History, tracking, invoice
- `ReviewController` — Post-purchase reviews
- `WishlistController`
- `AddressController`
- `BuyerDashboardController`
- `PaymentWebhookController` — Midtrans webhook handler
- `FlashSaleController`
- `Api/ShippingApiController`, `Api/CartApiController`, `Api/NotificationApiController`

**Views (resources/views/):**
- `layouts/marketplace.blade.php` — Main buyer layout (header, nav, footer)
- `home/index.blade.php` — Full homepage (hero, flash sale, categories, products)
- `products/index.blade.php` — Search + filter sidebar
- `products/show.blade.php` — Product detail page
- `stores/show.blade.php` — Store page
- `cart/index.blade.php`
- `checkout/` — step1-address, step2-shipping, step3-payment, step4-confirm
- `buyer/` — dashboard, orders/index, orders/show, reviews/create, wishlist
- `components/` — product-card, store-card, rating, price, badge, etc.

---

### Phase 9 — Routes Complete
Full route structure for all modules.

**Files:**
- `routes/web.php` — Complete (public, buyer, seller routes)
- `routes/api.php` — API endpoints

---

### Phase 10 — Homepage & UI Polish
Transform the welcome page into the marketplace homepage.

- Replace `welcome.blade.php` → redirect to `home/index.blade.php`
- Implement all 10 homepage sections (hero, flash sale, categories, etc.)
- Swiper.js sliders, Alpine.js interactivity
- SweetAlert2 for all confirmations and notifications
- Skeleton loading states
- Mobile-first responsive design
- Brand color system (#EE4D2D primary, Plus Jakarta Sans font)

---

## Execution Order

1. **Now:** Models → Seeders → Config/Helpers
2. **Next:** Services → Actions → DTOs  
3. **Then:** Jobs/Events/Notifications → Policies/Middleware
4. **Then:** Filament Admin resources
5. **Then:** Seller module complete
6. **Then:** Buyer module (homepage + product pages)
7. **Then:** Cart → Checkout → Payment webhook
8. **Then:** Routes complete + API endpoints
9. **Final:** UI polish, error pages, tests

---

## Verification Plan
- Run `php artisan migrate:fresh --seed` to verify all seeders work
- Run `php artisan serve` and manually test each module
- Browser test: homepage, product listing, product detail, cart, checkout flow
- Test seller onboarding → admin approval → product publish
- Test payment webhook (dummy mode)

---

## Open Questions

> [!IMPORTANT]
> **Payment**: No Midtrans API keys available. Will implement with a dummy payment fallback that simulates the full flow (approve/fail) for development.

> [!IMPORTANT]
> **Shipping**: No RajaOngkir API key. Will implement with hardcoded dummy shipping rates for development, with the real API abstracted behind a service interface.

> [!NOTE]
> **Meilisearch**: Not installed locally. Will use Laravel Scout with database driver as fallback (full-text search via LIKE queries). The service interface stays compatible with Meilisearch for production.

> [!NOTE]
> **Redis**: Will keep using database driver for queue/cache (as per current .env) to avoid Redis dependency for development.

> [!NOTE]
> **Filament v5**: Using latest stable. The Filament admin will be at `/admin` route.
