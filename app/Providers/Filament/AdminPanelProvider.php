<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Maison Connectée')
            ->favicon(asset('favicon.ico'))
            ->darkMode(false)
            ->colors([
                'primary' => Color::hex('#0097A7'),
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn(): HtmlString => new HtmlString($this->brandStyles())
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    private function brandStyles(): string
    {
        return <<<'HTML'
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet">
        <style>
            /* =============================================================
               MAISON CONNECTÉE — Charte graphique backoffice complète
               Primary   #0097A7  │  Secondary #42B7C4
               Neutre    #F2F2F2  │  Texte     #1A1A1A
               Sidebar   #1A1A1A  │  Surface   #ffffff
            ============================================================= */

            :root {
                --mc-primary:   #0097A7;
                --mc-secondary: #42B7C4;
                --mc-neutral:   #F2F2F2;
                --mc-text:      #1A1A1A;
                --mc-dark:      #1A1A1A;
                --mc-radius:    12px;
                --mc-shadow:    0 2px 12px rgba(0,0,0,0.06);
                --mc-shadow-lg: 0 8px 32px rgba(0,151,167,0.14);
            }

            *, *::before, *::after {
                font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
            }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               SIDEBAR
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            .fi-sidebar {
                background-color: var(--mc-dark) !important;
                border-right: none !important;
                box-shadow: 4px 0 24px rgba(0,0,0,0.15) !important;
            }

            /* Tous les éléments texte dans la sidebar en blanc par défaut */
            .fi-sidebar * { color: rgba(242,242,242,0.75); }

            /* Header / logo */
            .fi-sidebar-header {
                background-color: var(--mc-dark) !important;
                border-bottom: 1px solid rgba(0,151,167,0.25) !important;
                padding: 1.1rem 1rem !important;
            }
            .fi-logo, .fi-logo:hover { text-decoration: none !important; }
            .fi-brand-name,
            .fi-logo > span,
            .fi-sidebar-header a,
            .fi-sidebar-header span {
                color: #ffffff !important;
                font-weight: 800 !important;
                font-size: 1.05rem !important;
                letter-spacing: -0.02em !important;
            }

            /* Label de groupe — fi-nav-group-label (Filament 3) */
            .fi-nav-group-label,
            .fi-sidebar-group-label {
                color: var(--mc-secondary) !important;
                font-size: 0.6rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.15em !important;
                text-transform: uppercase !important;
                opacity: 1 !important;
                padding: 0.6rem 0.75rem 0.2rem !important;
            }

            /* Bouton nav item — fi-nav-item-button (Filament 3) */
            .fi-nav-item-button,
            .fi-sidebar-item-button,
            .fi-sidebar-item-btn {
                color: rgba(242,242,242,0.7) !important;
                border-radius: 8px !important;
                font-size: 0.875rem !important;
                font-weight: 500 !important;
                transition: background 0.15s ease, color 0.15s ease !important;
            }
            .fi-nav-item-button svg,
            .fi-sidebar-item-button svg,
            .fi-sidebar-item-btn svg {
                color: rgba(242,242,242,0.6) !important;
            }
            .fi-nav-item-button:hover,
            .fi-sidebar-item-button:hover,
            .fi-sidebar-item-btn:hover {
                background-color: rgba(0,151,167,0.18) !important;
                color: #ffffff !important;
            }
            .fi-nav-item-button:hover svg,
            .fi-sidebar-item-button:hover svg,
            .fi-sidebar-item-btn:hover svg {
                color: var(--mc-secondary) !important;
            }

            /* Item actif */
            .fi-nav-item-active .fi-nav-item-button,
            .fi-nav-item-button[aria-current="page"],
            .fi-nav-item-button.fi-active,
            .fi-sidebar-item-active .fi-sidebar-item-btn,
            .fi-sidebar-item-btn[aria-current="page"] {
                background: linear-gradient(135deg, var(--mc-primary) 0%, #00b5c8 100%) !important;
                color: #ffffff !important;
                font-weight: 600 !important;
                box-shadow: 0 4px 14px rgba(0,151,167,0.4) !important;
            }
            .fi-nav-item-active .fi-nav-item-button svg,
            .fi-nav-item-button[aria-current="page"] svg,
            .fi-sidebar-item-active .fi-sidebar-item-btn svg,
            .fi-sidebar-item-btn[aria-current="page"] svg {
                color: #ffffff !important;
            }

            /* Footer sidebar */
            .fi-sidebar-footer {
                background-color: #111111 !important;
                border-top: 1px solid rgba(0,151,167,0.18) !important;
            }
            .fi-sidebar-footer .fi-avatar { border: 2px solid var(--mc-primary) !important; }
            .fi-sidebar-footer span,
            .fi-sidebar-footer p { color: rgba(242,242,242,0.75) !important; }

            /* Scrollbar sidebar */
            .fi-sidebar::-webkit-scrollbar { width: 3px; }
            .fi-sidebar::-webkit-scrollbar-track { background: transparent; }
            .fi-sidebar::-webkit-scrollbar-thumb {
                background: rgba(0,151,167,0.35);
                border-radius: 2px;
            }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               TOPBAR
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            .fi-topbar,
            .fi-topbar nav,
            header.fi-topbar {
                background-color: #ffffff !important;
                border-bottom: 2px solid var(--mc-primary) !important;
                box-shadow: 0 1px 16px rgba(0,151,167,0.07) !important;
            }
            .fi-topbar .fi-icon-btn { color: #64748b !important; }
            .fi-topbar .fi-icon-btn:hover {
                background-color: rgba(0,151,167,0.08) !important;
                color: var(--mc-primary) !important;
            }
            /* Breadcrumb topbar */
            .fi-breadcrumbs ol li a { color: var(--mc-primary) !important; }
            .fi-breadcrumbs ol li:last-child span { color: var(--mc-text) !important; }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               LAYOUT & FOND DE PAGE
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            .fi-layout, .fi-main-ctn, .fi-main,
            .fi-page, .fi-body, body {
                background-color: var(--mc-neutral) !important;
            }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               EN-TÊTE DE PAGE
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            .fi-page-header-heading,
            .fi-page-heading,
            h1.fi-heading {
                color: var(--mc-text) !important;
                font-weight: 800 !important;
                font-size: 1.5rem !important;
                letter-spacing: -0.02em !important;
            }
            .fi-page-header-subheading { color: #64748b !important; }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               BOUTONS — toutes variantes
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            /* Primary */
            .fi-btn-color-primary {
                background-color: var(--mc-primary) !important;
                border-color: var(--mc-primary) !important;
                color: #ffffff !important;
                font-weight: 600 !important;
                border-radius: 8px !important;
                box-shadow: 0 2px 8px rgba(0,151,167,0.25) !important;
                transition: all 0.15s ease !important;
            }
            .fi-btn-color-primary:hover {
                background-color: var(--mc-secondary) !important;
                border-color: var(--mc-secondary) !important;
                box-shadow: 0 4px 16px rgba(0,151,167,0.35) !important;
                transform: translateY(-1px) !important;
            }
            /* Gray / secondary */
            .fi-btn-color-gray {
                background-color: #ffffff !important;
                border-color: #e2e8f0 !important;
                color: var(--mc-text) !important;
                border-radius: 8px !important;
                font-weight: 500 !important;
            }
            .fi-btn-color-gray:hover {
                background-color: var(--mc-neutral) !important;
                border-color: var(--mc-primary) !important;
                color: var(--mc-primary) !important;
            }
            /* Danger */
            .fi-btn-color-danger {
                background-color: #ef4444 !important;
                border-color: #ef4444 !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
            }
            .fi-btn-color-danger:hover {
                background-color: #dc2626 !important;
                transform: translateY(-1px) !important;
            }
            /* Success */
            .fi-btn-color-success {
                background-color: #10b981 !important;
                border-radius: 8px !important;
            }
            /* Icon buttons */
            .fi-icon-btn {
                border-radius: 8px !important;
                transition: all 0.15s ease !important;
            }
            .fi-icon-btn:hover {
                background-color: rgba(0,151,167,0.1) !important;
                color: var(--mc-primary) !important;
            }
            /* All buttons border-radius */
            .fi-btn { border-radius: 8px !important; }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               TABLEAUX
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            /* Conteneur table widget */
            .fi-ta-ctn, .fi-wi-table {
                background-color: #ffffff !important;
                border-radius: var(--mc-radius) !important;
                border: 1px solid rgba(0,0,0,0.05) !important;
                box-shadow: var(--mc-shadow) !important;
                overflow: hidden !important;
            }
            /* Toolbar (search, filters, actions) */
            .fi-ta-header-ctn {
                background-color: #ffffff !important;
                border-bottom: 1px solid rgba(0,0,0,0.06) !important;
                padding: 0.75rem 1rem !important;
            }
            .fi-ta-heading {
                color: var(--mc-text) !important;
                font-weight: 700 !important;
                font-size: 1rem !important;
            }
            /* Header colonnes */
            .fi-ta-header-row > th {
                background-color: #f8fafc !important;
                color: #64748b !important;
                font-weight: 600 !important;
                font-size: 0.7rem !important;
                text-transform: uppercase !important;
                letter-spacing: 0.08em !important;
                border-bottom: 1px solid #e2e8f0 !important;
                padding: 0.65rem 1rem !important;
            }
            /* Tri actif */
            .fi-ta-col-header-sort-icon { color: var(--mc-primary) !important; }
            /* Lignes */
            .fi-ta-row > td {
                color: var(--mc-text) !important;
                font-size: 0.875rem !important;
                border-bottom: 1px solid rgba(0,0,0,0.04) !important;
                padding: 0.75rem 1rem !important;
            }
            .fi-ta-row:hover > td {
                background-color: rgba(0,151,167,0.03) !important;
            }
            /* Checkbox sélection */
            .fi-ta-row-checkbox:checked {
                background-color: var(--mc-primary) !important;
                border-color: var(--mc-primary) !important;
            }
            /* Pagination */
            .fi-pagination { padding: 0.75rem 1rem !important; }
            .fi-pagination-item-btn.fi-active,
            .fi-pagination-item-btn[aria-current="page"] {
                background-color: var(--mc-primary) !important;
                color: #ffffff !important;
                border-color: var(--mc-primary) !important;
                border-radius: 6px !important;
            }
            .fi-pagination-item-btn {
                border-radius: 6px !important;
                font-weight: 500 !important;
                color: #64748b !important;
            }
            .fi-pagination-item-btn:hover {
                background-color: rgba(0,151,167,0.08) !important;
                color: var(--mc-primary) !important;
            }
            /* Actions de ligne */
            .fi-ta-actions .fi-icon-btn { border-radius: 6px !important; }
            /* Bulk actions */
            .fi-ta-bulk-actions-ctn {
                background-color: rgba(0,151,167,0.06) !important;
                border-top: 1px solid rgba(0,151,167,0.15) !important;
            }
            /* Empty state */
            .fi-ta-empty-state-icon { color: var(--mc-secondary) !important; }
            .fi-ta-empty-state-heading { color: var(--mc-text) !important; font-weight: 600 !important; }
            /* Search input */
            .fi-ta-search-input { border-radius: 8px !important; }
            /* Filter chips */
            .fi-ta-filter-indicator {
                background-color: rgba(0,151,167,0.1) !important;
                color: var(--mc-primary) !important;
                border-radius: 6px !important;
                font-weight: 600 !important;
                font-size: 0.75rem !important;
            }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               FORMULAIRES
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            /* Section / card */
            .fi-section {
                background-color: #ffffff !important;
                border-radius: var(--mc-radius) !important;
                border: 1px solid rgba(0,0,0,0.06) !important;
                box-shadow: var(--mc-shadow) !important;
            }
            .fi-section-header-heading {
                color: var(--mc-text) !important;
                font-weight: 700 !important;
                font-size: 0.95rem !important;
            }
            /* Inputs */
            .fi-input-wrp, .fi-input,
            .fi-select-input, .fi-textarea,
            .fi-fo-rich-editor {
                border-radius: 8px !important;
                border-color: #e2e8f0 !important;
                font-size: 0.875rem !important;
                background-color: #ffffff !important;
                color: var(--mc-text) !important;
            }
            .fi-input:focus, .fi-select-input:focus, .fi-textarea:focus {
                border-color: var(--mc-primary) !important;
                box-shadow: 0 0 0 3px rgba(0,151,167,0.12) !important;
            }
            /* Champ désactivé */
            .fi-input[disabled], .fi-select-input[disabled], .fi-textarea[disabled],
            [disabled] .fi-input, [disabled] .fi-select-input {
                background-color: #f8fafc !important;
                color: #94a3b8 !important;
                cursor: not-allowed !important;
            }
            /* Labels */
            .fi-fo-field-wrp-label, label {
                color: var(--mc-text) !important;
                font-weight: 600 !important;
                font-size: 0.82rem !important;
            }
            /* Helper text */
            .fi-fo-field-wrp-hint { color: #94a3b8 !important; font-size: 0.75rem !important; }
            /* Error */
            .fi-fo-field-wrp-error-message { color: #ef4444 !important; font-size: 0.75rem !important; }
            /* Select — options dropdown */
            .choices__list--dropdown, .choices__list[aria-expanded] {
                background-color: #ffffff !important;
                border-color: #e2e8f0 !important;
                border-radius: 8px !important;
            }
            .choices__item, .choices__item--choice {
                color: var(--mc-text) !important;
                background-color: transparent !important;
            }
            .choices__item--selectable.is-highlighted {
                background-color: rgba(0,151,167,0.08) !important;
                color: var(--mc-primary) !important;
            }
            /* Listbox / combobox natif Filament */
            [role="listbox"], [role="option"] {
                background-color: #ffffff !important;
                color: var(--mc-text) !important;
            }
            [role="option"]:hover, [role="option"][aria-selected="true"] {
                background-color: rgba(0,151,167,0.08) !important;
                color: var(--mc-primary) !important;
            }
            /* Toggle / switch ON */
            .fi-fo-toggle-input:checked {
                background-color: var(--mc-primary) !important;
                border-color: var(--mc-primary) !important;
            }
            /* Checkbox checked */
            .fi-checkbox-input:checked {
                background-color: var(--mc-primary) !important;
                border-color: var(--mc-primary) !important;
            }
            /* Radio checked */
            .fi-radio-input:checked {
                border-color: var(--mc-primary) !important;
                background-color: var(--mc-primary) !important;
            }
            /* Select */
            .fi-select-input:focus { border-color: var(--mc-primary) !important; }
            /* File upload */
            .fi-fo-file-upload {
                border-color: rgba(0,151,167,0.3) !important;
                border-radius: 10px !important;
                background-color: rgba(0,151,167,0.03) !important;
            }
            .fi-fo-file-upload:hover { border-color: var(--mc-primary) !important; }
            /* Color picker swatch */
            .fi-fo-color-picker-preview { border-radius: 6px !important; }
            /* Date picker */
            .fi-fo-date-picker-btn:hover { background-color: rgba(0,151,167,0.1) !important; }
            .fi-fo-date-picker-btn[aria-current="date"] {
                background-color: var(--mc-primary) !important;
                color: #ffffff !important;
            }
            /* Repeater */
            .fi-fo-repeater-item {
                border-radius: 10px !important;
                border-color: rgba(0,0,0,0.07) !important;
            }
            .fi-fo-repeater-item-header { background-color: #f8fafc !important; border-radius: 10px 10px 0 0 !important; }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               WIDGETS DASHBOARD
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            /* Stats overview */
            .fi-wi-stats-overview-stat {
                background-color: #ffffff !important;
                border-radius: var(--mc-radius) !important;
                border: 1px solid rgba(0,151,167,0.09) !important;
                box-shadow: var(--mc-shadow) !important;
                transition: all 0.2s ease !important;
                overflow: hidden !important;
            }
            .fi-wi-stats-overview-stat:hover {
                box-shadow: var(--mc-shadow-lg) !important;
                transform: translateY(-2px) !important;
                border-color: rgba(0,151,167,0.25) !important;
            }
            .fi-wi-stats-overview-stat-value {
                font-size: 1.85rem !important;
                font-weight: 800 !important;
                color: var(--mc-text) !important;
                letter-spacing: -0.03em !important;
            }
            .fi-wi-stats-overview-stat-label {
                font-weight: 600 !important;
                color: var(--mc-text) !important;
                font-size: 0.82rem !important;
            }
            .fi-wi-stats-overview-stat-description {
                font-size: 0.75rem !important;
                font-weight: 500 !important;
            }
            /* Chart widgets */
            .fi-wi-chart {
                background-color: #ffffff !important;
                border-radius: var(--mc-radius) !important;
                border: 1px solid rgba(0,0,0,0.05) !important;
                box-shadow: var(--mc-shadow) !important;
            }
            .fi-wi-heading {
                color: var(--mc-text) !important;
                font-weight: 700 !important;
                font-size: 1rem !important;
            }
            .fi-wi-description { color: #64748b !important; font-size: 0.8rem !important; }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               MODALES & DIALOGS
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            .fi-modal-window {
                border-radius: 16px !important;
                box-shadow: 0 24px 64px rgba(0,0,0,0.18) !important;
            }
            .fi-modal-header {
                border-bottom: 1px solid rgba(0,151,167,0.12) !important;
                padding: 1.25rem 1.5rem !important;
            }
            .fi-modal-header-heading {
                color: var(--mc-text) !important;
                font-weight: 700 !important;
                font-size: 1.1rem !important;
            }
            .fi-modal-footer {
                border-top: 1px solid rgba(0,0,0,0.06) !important;
                background-color: #f8fafc !important;
                border-radius: 0 0 16px 16px !important;
            }
            /* Confirmation modal (delete) */
            .fi-modal-window .fi-color-danger .fi-modal-header-icon {
                background-color: rgba(239,68,68,0.1) !important;
            }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               DROPDOWNS & MENUS
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            .fi-dropdown-panel {
                border-radius: 10px !important;
                box-shadow: 0 8px 32px rgba(0,0,0,0.12) !important;
                border: 1px solid rgba(0,0,0,0.06) !important;
                overflow: hidden !important;
            }
            .fi-dropdown-item-btn {
                font-size: 0.875rem !important;
                font-weight: 500 !important;
                border-radius: 0 !important;
                color: var(--mc-text) !important;
            }
            .fi-dropdown-item-btn:hover {
                background-color: rgba(0,151,167,0.07) !important;
                color: var(--mc-primary) !important;
            }
            .fi-dropdown-item-btn.fi-color-danger:hover {
                background-color: rgba(239,68,68,0.08) !important;
                color: #ef4444 !important;
            }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               NOTIFICATIONS
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            .fi-notification {
                background-color: #ffffff !important;
                border-radius: 12px !important;
                box-shadow: 0 8px 32px rgba(0,0,0,0.1) !important;
                border: 1px solid rgba(0,0,0,0.06) !important;
            }
            .fi-notification-icon.fi-color-success { color: #10b981 !important; }
            .fi-notification-icon.fi-color-danger  { color: #ef4444 !important; }
            .fi-notification-icon.fi-color-info    { color: var(--mc-primary) !important; }
            .fi-notification-icon.fi-color-primary { color: var(--mc-primary) !important; }
            .fi-notification-title { font-weight: 700 !important; color: var(--mc-text) !important; }
            .fi-notification-body  { font-size: 0.8rem !important; color: #64748b !important; }
            /* Description de table (message info verrouillage) */
            .fi-ta-description { color: #64748b !important; font-size: 0.82rem !important; }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               BADGES & INDICATEURS
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            .fi-badge {
                border-radius: 6px !important;
                font-weight: 600 !important;
                font-size: 0.7rem !important;
                letter-spacing: 0.02em !important;
            }
            .fi-badge-color-primary {
                background-color: rgba(0,151,167,0.12) !important;
                color: var(--mc-primary) !important;
            }
            .fi-badge-color-success {
                background-color: rgba(16,185,129,0.12) !important;
                color: #059669 !important;
            }
            .fi-badge-color-danger {
                background-color: rgba(239,68,68,0.12) !important;
                color: #dc2626 !important;
            }
            .fi-badge-color-warning {
                background-color: rgba(245,158,11,0.12) !important;
                color: #d97706 !important;
            }
            .fi-badge-color-info,
            .fi-badge-color-secondary {
                background-color: rgba(66,183,196,0.12) !important;
                color: var(--mc-secondary) !important;
            }
            /* Icon column boolean */
            .fi-ta-col-icon svg { border-radius: 50% !important; }

            /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
               ACCOUNT WIDGET
            ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
            .fi-wi-account {
                background: linear-gradient(135deg, var(--mc-primary) 0%, #005f6b 100%) !important;
                border-radius: var(--mc-radius) !important;
                border: none !important;
                color: #ffffff !important;
            }
            .fi-wi-account .fi-wi-account-name { color: #ffffff !important; font-weight: 700 !important; }
            .fi-wi-account .fi-wi-account-email { color: rgba(255,255,255,0.7) !important; }
            .fi-wi-account .fi-avatar { border: 2px solid rgba(255,255,255,0.4) !important; }
        </style>
        HTML;
    }
}
