# TechCommers — Task Checklist

## Phase 1 — Models & Foundation
- [/] All 31 Eloquent models with relationships/fillable/casts
- [ ] Traits: HasSlug, HasCurrency, HasAuditLog
- [ ] Observers: OrderObserver, ProductObserver
- [ ] Helpers: formatRupiah, formatDate, formatWeight
- [ ] Config: app.php (locale, timezone)
- [ ] AppServiceProvider

## Phase 2 — Seeders & Factories
- [ ] RolePermissionSeeder
- [ ] UserSeeder
- [ ] CategorySeeder
- [ ] StoreSeeder
- [ ] ProductSeeder
- [ ] OrderSeeder + OrderItemSeeder
- [ ] ReviewSeeder
- [ ] VoucherSeeder + FlashSaleSeeder
- [ ] PlatformSettingSeeder
- [ ] All Factories
- [ ] DatabaseSeeder orchestration

## Phase 3 — Services Layer
- [ ] CartService
- [ ] OrderService
- [ ] CheckoutService
- [ ] PaymentService (Midtrans + dummy)
- [ ] CommissionService
- [ ] StockService
- [ ] WalletService
- [ ] ShippingService (RajaOngkir + dummy)
- [ ] ProductService
- [ ] DTOs + Actions

## Phase 4 — Jobs, Events, Notifications
- [ ] Events (4)
- [ ] Listeners
- [ ] Jobs (4)
- [ ] Notifications (3)
- [ ] Mail classes

## Phase 5 — Policies & Middleware
- [ ] ProductPolicy, OrderPolicy, StorePolicy
- [ ] EnsureRole, PreventBannedUser, TrackRecentlyViewed
- [ ] Register in bootstrap/app.php

## Phase 6 — Filament Admin
- [ ] UserResource (full CRUD)
- [ ] StoreResource (approval workflow)
- [ ] ProductResource
- [ ] OrderResource
- [ ] CategoryResource
- [ ] WithdrawalResource
- [ ] PlatformSettingResource
- [ ] Admin Dashboard widgets

## Phase 7 — Seller Module
- [ ] Seller layout (sidebar)
- [ ] Dashboard with charts
- [ ] Product CRUD (with variants/images)
- [ ] Order management
- [ ] Wallet + withdrawal
- [ ] Vouchers + Flash sales

## Phase 8 — Buyer Module
- [ ] Marketplace layout (header/footer)
- [ ] Homepage (10 sections)
- [ ] Product listing + search/filter
- [ ] Product detail page
- [ ] Store page
- [ ] Cart system
- [ ] Checkout flow (4 steps)
- [ ] Order tracking
- [ ] Review system
- [ ] Wishlist + dashboard

## Phase 9 — Routes
- [ ] web.php complete
- [ ] api.php
- [ ] Payment webhook routes

## Phase 10 — UI Polish
- [ ] SweetAlert2 everywhere
- [ ] Alpine.js reactivity
- [ ] Error pages (404, 403, 500)
- [ ] Mobile responsive audit
- [ ] Final DB seeding test
