# PAHEWO Cross-Border Trade Information System

You are working inside an **existing Laravel application**.

Laravel is already installed and configured.

Do **not** start by explaining how to install Laravel, Composer, PHP, MySQL, Node.js, npm, or how to create a new Laravel project.

Start directly with the architecture, database migrations, models, relationships, authentication/authorization structure, controllers/services, routes, Blade components, forms, dashboards, and implementation.

---

# 1. Project Overview

Build a multilingual cross-border trade information management system called **PAHEWO**.

The platform is designed to help cross-border traders access reliable and frequently updated information across **three countries**.

The system must allow authorized users to collect and manage:

- Daily commodity prices
- Markets
- Commodity categories
- Measurement units
- Exchange rates
- Forex bureaus
- Border crossings
- Travel documents
- Border/travel requirements
- Claims and complaints
- Claim types
- Claim attachments
- Contact persons
- Countries
- Languages
- Currencies
- Users
- Roles and permissions
- Reports and statistics

The system must support information collected in different languages and prices recorded in different currencies.

The architecture must be scalable enough to add more countries, languages, currencies, markets, and modules later.

---

# 2. Main Design Principles

Follow these principles throughout the application.

## Multi-country architecture

Never hardcode the three countries into business logic.

Create a `countries` table and relate data to countries using foreign keys.

The system should support adding additional countries later.

The Super Administrator can access all countries.

Country-level users should only access information belonging to the countries assigned to them.

## Multilingual architecture

Do not create fields such as:

```text
name_en
name_fr
name_sw
description_en
description_fr
```

Use translation tables instead.

Example:

```text
commodities
commodity_translations

commodity_categories
commodity_category_translations

measurement_units
measurement_unit_translations

travel_documents
travel_document_translations

claim_types
claim_type_translations
```

A translation should reference a language using `language_id`.

Create a `languages` table.

Example languages may include:

```text
English
French
Kiswahili
```

The system must make it possible to add additional languages without changing the database structure.

---

# 3. Currency Architecture

Create a `currencies` table.

Suggested fields:

```text
id
code
name
symbol
decimal_places
is_active
timestamps
```

Examples:

```text
USD
CDF
RWF
BIF
```

Use the currency code internally rather than relying on the currency symbol.

Prices must always store the currency in which they were originally recorded.

For example:

```text
Commodity: Maize
Price: 3500
Currency: CDF
```

Do not overwrite the original price when displaying another currency.

Currency conversion should happen when displaying information.

---

# 4. Required Models

Create appropriate Laravel models, migrations, factories when useful, and relationships for the following entities.

```text
Country
Language
Currency

User
Role
Permission

Market
BorderCrossing
ForexBureau

MeasurementUnit
MeasurementUnitTranslation

CommodityCategory
CommodityCategoryTranslation

Commodity
CommodityTranslation
CommodityPrice

ExchangeRate

DocumentType
DocumentTypeTranslation

TravelDocument
TravelDocumentTranslation

ClaimType
ClaimTypeTranslation

Claim
ClaimAttachment
ClaimStatusHistory

ContactPerson
```

Use appropriate model names, table names, foreign keys, indexes, constraints, casts, and timestamps.

---

# 5. Country Model

Suggested fields:

```text
countries
---------
id
name
iso_code
phone_code
is_active
timestamps
```

Relationships may include:

```text
Country hasMany Markets
Country hasMany ForexBureaus
Country hasMany TravelDocuments
Country hasMany Claims
Country belongsToMany Currencies
Country belongsToMany Users
```

Use a many-to-many `country_user` relationship if users can be assigned to multiple countries.

---

# 6. Languages

Create:

```text
languages
---------
id
code
name
is_active
timestamps
```

Example:

```text
en | English
fr | Français
sw | Kiswahili
```

Users should have a preferred language.

Example:

```text
users.preferred_language_id
```

---

# 7. Markets

Create a market model.

Suggested structure:

```text
markets
-------
id
country_id
name
city
address nullable
latitude nullable
longitude nullable
is_active
timestamps
```

Relationships:

```text
Market belongsTo Country
Market hasMany CommodityPrices
```

A data collector may optionally be assigned to one or several markets.

---

# 8. Border Crossings

Use the model name:

```text
BorderCrossing
```

rather than simply `Border`.

Suggested structure:

```text
border_crossings
----------------
id
name
country_a_id
country_b_id
latitude nullable
longitude nullable
opening_time nullable
closing_time nullable
status
is_active
timestamps
```

Both:

```text
country_a_id
country_b_id
```

should reference `countries`.

Possible statuses:

```text
open
restricted
temporarily_closed
closed
```

Use an enum where appropriate.

---

# 9. Commodity Categories

Create:

```text
commodity_categories
--------------------
id
code
is_active
timestamps
```

Translations:

```text
commodity_category_translations
-------------------------------
id
commodity_category_id
language_id
name
description nullable
timestamps
```

Examples:

```text
CEREALS
VEGETABLES
FRUITS
LIVESTOCK
FISH
OTHER
```

---

# 10. Measurement Units

Create:

```text
measurement_units
-----------------
id
code
symbol
is_active
timestamps
```

Examples:

```text
kg
litre
bag
tonne
piece
```

Translations:

```text
measurement_unit_translations
-----------------------------
id
measurement_unit_id
language_id
name
timestamps
```

---

# 11. Commodities

Create:

```text
commodities
-----------
id
commodity_category_id
measurement_unit_id
code
is_active
timestamps
```

Translations:

```text
commodity_translations
----------------------
id
commodity_id
language_id
name
description nullable
timestamps
```

Relationships:

```text
Commodity belongsTo CommodityCategory
Commodity belongsTo MeasurementUnit
Commodity hasMany CommodityTranslations
Commodity hasMany CommodityPrices
```

---

# 12. Commodity Prices

Commodity prices must support historical data.

Never store the current price directly on the commodity table.

Create:

```text
commodity_prices
----------------
id
commodity_id
market_id
currency_id
price
price_date
created_by
notes nullable
timestamps
```

Relationships:

```text
CommodityPrice belongsTo Commodity
CommodityPrice belongsTo Market
CommodityPrice belongsTo Currency
CommodityPrice belongsTo User through created_by
```

Use a decimal type appropriate for monetary values.

Add appropriate indexes.

Prevent accidental duplicate entries for the same:

```text
commodity
market
currency
date
```

unless there is a deliberate business reason to allow multiple entries.

---

# 13. Exchange Rates

Create:

```text
exchange_rates
--------------
id
country_id
base_currency_id
quote_currency_id
rate
rate_date
source nullable
created_by
timestamps
```

Relationships:

```text
ExchangeRate belongsTo Country
ExchangeRate belongsTo Currency as baseCurrency
ExchangeRate belongsTo Currency as quoteCurrency
ExchangeRate belongsTo User as creator
```

Example:

```text
Base: USD
Quote: CDF
Rate: 2850

Meaning:

1 USD = 2850 CDF
```

Exchange-rate history must be preserved.

---

# 14. Forex Bureaus

Create:

```text
forex_bureaus
-------------
id
country_id
name
city
address nullable
phone nullable
latitude nullable
longitude nullable
is_active
timestamps
```

Prepare the architecture so bureau-specific buy and sell rates can be added.

Optionally create:

```text
forex_rates
-----------
id
forex_bureau_id
base_currency_id
quote_currency_id
buy_rate
sell_rate
rate_date
created_by
timestamps
```

---

# 15. Travel Documents

Create document types separately from travel-document requirements.

Example document types:

```text
Passport
National ID
Laissez-passer
Visa
Yellow Fever Certificate
Customs Declaration
Trader Permit
```

Suggested:

```text
document_types
--------------
id
code
is_active
timestamps
```

Translations:

```text
document_type_translations
--------------------------
id
document_type_id
language_id
name
description nullable
timestamps
```

Create:

```text
travel_documents
----------------
id
country_id
document_type_id
is_required
validity_days nullable
fee nullable
fee_currency_id nullable
is_active
timestamps
```

Translations:

```text
travel_document_translations
----------------------------
id
travel_document_id
language_id
title
description nullable
requirements nullable
instructions nullable
timestamps
```

The architecture should later be able to support requirements based on:

```text
from_country_id
to_country_id
```

because document requirements may depend on the travel direction.

---

# 16. Claims

Create a structured claim-management system.

Suggested table:

```text
claims
------
id
reference_number
user_id
country_id
border_crossing_id nullable
market_id nullable
claim_type_id
title
description
status
occurred_at nullable
submitted_at nullable
resolved_at nullable
timestamps
```

Generate a human-friendly claim reference such as:

```text
CLM-2026-000001
```

Possible statuses:

```text
submitted
under_review
pending
resolved
rejected
closed
```

Use a PHP enum for claim statuses.

---

# 17. Claim Types

Create:

```text
claim_types
-----------
id
code
is_active
timestamps
```

Translations:

```text
claim_type_translations
-----------------------
id
claim_type_id
language_id
name
description nullable
timestamps
```

Possible types:

```text
ILLEGAL_FEE
HARASSMENT
BORDER_DELAY
DOCUMENT_PROBLEM
CONFISCATION
MARKET_DISPUTE
OTHER
```

---

# 18. Claim Status History

Do not only overwrite the claim status.

Create an audit trail:

```text
claim_status_histories
----------------------
id
claim_id
status
comment nullable
changed_by
timestamps
```

When a claim changes from:

```text
submitted
```

to:

```text
under_review
```

create a status-history entry.

The claim detail page should display the status history as a timeline.

---

# 19. Claim Attachments

Create:

```text
claim_attachments
-----------------
id
claim_id
file_path
file_name nullable
mime_type nullable
file_size nullable
uploaded_by
timestamps
```

Allow appropriate file types such as:

```text
images
PDF documents
receipts
supporting documents
```

Implement proper validation and secure storage.

---

# 20. Contact Persons

Create:

```text
contact_persons
---------------
id
country_id nullable
border_crossing_id nullable
market_id nullable
name
organization nullable
position nullable
phone nullable
email nullable
is_active
timestamps
```

Contact persons should be usable for:

```text
markets
border crossings
countries
support
```

---

# 21. Users and Access Control

Use role-based and permission-based authorization.

Prefer a permission structure compatible with:

```text
spatie/laravel-permission
```

Suggested roles:

```text
Super Admin
Country Admin
Data Collector
Market Officer
Border Officer
Claim Officer
Trader
```

Do not rely only on code such as:

```php
if ($user->role === 'admin')
```

Use permissions.

Examples:

```text
countries.view
countries.manage

markets.view
markets.create
markets.update
markets.delete

commodities.view
commodities.create
commodities.update
commodities.delete

prices.view
prices.create
prices.update
prices.delete

exchange_rates.view
exchange_rates.create
exchange_rates.update

claims.create
claims.view
claims.review
claims.resolve

travel_documents.view
travel_documents.manage

users.view
users.manage

roles.manage

reports.view
```

Use Laravel Policies and Gates where appropriate.

---

# 22. Role-Based Navigation

The sidebar should only display menu items for which the user has permission.

## Super Admin Menu

```text
PAHEWO

TABLEAU DE BORD
🏠 Vue d’ensemble
📊 Statistiques

INFORMATIONS COMMERCIALES
🏪 Marchés
📦 Marchandises
💰 Prix journaliers
💱 Taux de change
🏦 Bureaux de change

INFORMATIONS FRONTALIÈRES
🚧 Postes frontaliers
📄 Documents de voyage

RÉCLAMATIONS
📝 Réclamations
🏷 Types de réclamations

CONFIGURATION
🌍 Pays
🗣 Langues
💵 Devises
⚖ Unités de mesure
📂 Catégories de marchandises

UTILISATEURS ET ACCÈS
👥 Utilisateurs
🛡 Rôles et autorisations

RAPPORTS
📊 Rapports
📈 Tendances des prix
📈 Tendances des taux de change
📋 Rapports sur les réclamations

SYSTÈME
👤 Personnes de contact
⚙ Paramètres
```

## Data Collector Menu

```text
PAHEWO

TABLEAU DE BORD
🏠 Accueil

COLLECTE DES DONNÉES
➕ Enregistrer un prix
💰 Prix du jour
➕ Enregistrer un taux de change
💱 Taux de change du jour

MON ACTIVITÉ
📋 Mes soumissions
🕒 Historique des soumissions

COMPTE
👤 Mon profil
🌐 Langue
```

## Trader Menu

```text
PAHEWO

🏠 Accueil

INFORMATIONS DU MARCHÉ
💰 Prix du jour
🔎 Comparer les prix
📈 Tendances des prix

DEVISES
💱 Taux de change
🧮 Convertisseur de devises
🏦 Bureaux de change

FRONTIÈRE ET VOYAGE
🚧 Informations frontalières
📄 Documents de voyage
📋 Exigences de voyage

RÉCLAMATIONS
➕ Soumettre une réclamation
📋 Mes réclamations

ASSISTANCE
👤 Personnes de contact
❓ Aide

COMPTE
👤 Mon profil
🌐 Langue
```

---

# 23. Admin Dashboard

The administrator dashboard should answer:

1. What is happening today?
2. Is today's data collection complete?
3. Which countries or markets need attention?
4. What are the major commodity-price changes?
5. What are today's exchange rates?
6. Are there unresolved claims?
7. What has happened recently?

Use a global country filter:

```text
Pays : [Tous les pays ▼]
```

Super Administrators can choose all countries.

Country Administrators should only see their permitted countries.

## Admin dashboard layout

```text
┌──────────────────────────────────────────────────────────────────┐
│ Tableau de bord                     Pays : [Tous les pays ▼]      │
│ Mardi 11 août 2026                                                │
├──────────────┬──────────────┬──────────────┬─────────────────────┤
│ 🏪 Marchés   │ 💰 Prix      │ 💱 Taux     │ 📝 Réclamations     │
│     24       │ 186 aujourd. │ 12 aujourd. │ 7 non résolues      │
├──────────────┴──────────────┴──────────────┴─────────────────────┤
│                                                                  │
│ COLLECTE DES DONNÉES DU JOUR                                     │
│ █████████████████░░░ 89 %                                        │
│                                                                  │
│ Pays A  ███████████████████ 96 %                                 │
│ Pays B  █████████████████░░ 91 %                                 │
│ Pays C  ████████████░░░░░░░ 68 % ⚠                              │
│                                                                  │
├────────────────────────────────┬─────────────────────────────────┤
│ TENDANCES DES PRIX             │ TAUX DE CHANGE                  │
│                                │                                 │
│ 📈 Graphique                   │ USD/CDF  2 850 ↑ 1,2 %          │
│                                │ USD/RWF  1 420 ↓ 0,4 %          │
│ Marchandise : [Maïs ▼]         │ USD/BIF  2 950 ↑ 0,7 %          │
├────────────────────────────────┼─────────────────────────────────┤
│ RÉCLAMATIONS                   │ NÉCESSITE UNE ATTENTION         │
│                                │                                 │
│ Nouvelles            12       │ ⚠ Prix manquants — Marché A     │
│ En cours d'examen    18       │ ⚠ Données incomplètes — Marché B│
│ En retard             7 ⚠     │ ⚠ Taux de change non actualisé  │
│ Résolues             101      │ ⚠ 7 réclamations en retard      │
├────────────────────────────────┴─────────────────────────────────┤
│ ACTIVITÉ RÉCENTE                                                 │
│ 10:42 Jean a enregistré 12 prix de marchandises                 │
│ 10:31 Marie a mis à jour le taux USD/CDF                        │
│ 10:15 Nouvelle réclamation CLM-00218                            │
│ 09:52 Exigences de voyage mises à jour                          │
└──────────────────────────────────────────────────────────────────┘
```

---

# 24. Data Collector Dashboard

Keep this dashboard simple and task-oriented.

It should answer:

```text
What do I need to collect today?
What have I already submitted?
What information is still missing?
```

Design:

```text
┌──────────────────────────────────────────────────────────────────┐
│ Tableau de bord                              📅 11 août 2026      │
│ Bonjour Jean                                                     │
│ Marché : [Marché central ▼]              Pays : [Mon pays]       │
├───────────────────┬───────────────────┬──────────────────────────┤
│ 📦 PRIX DU JOUR   │ 💱 TAUX DU JOUR  │ ✅ PROGRESSION           │
│       18          │        3          │        84 %              │
│ prix enregistrés  │ taux enregistrés │ données collectées       │
├───────────────────┴───────────────────┴──────────────────────────┤
│                                                                  │
│ COLLECTE DES DONNÉES DU JOUR                                     │
│ █████████████████░░░ 84 %                                        │
│                                                                  │
│ Prix des marchandises       18 / 22    82 %                      │
│ Taux de change               3 / 3     100 %                     │
│                                                                  │
│ ⚠ 4 prix restent à enregistrer                                  │
├────────────────────────────────┬─────────────────────────────────┤
│ ACTIONS RAPIDES                │ DONNÉES MANQUANTES              │
│                                │                                 │
│ ➕ Enregistrer un prix         │ ⚠ Maïs                          │
│ ➕ Enregistrer un taux         │ ⚠ Haricots                      │
│ 📋 Voir mes soumissions        │ ⚠ Riz                           │
│                                │ ⚠ Pommes de terre               │
├────────────────────────────────┴─────────────────────────────────┤
│ DERNIÈRES SOUMISSIONS                                            │
│ 14:32 Maïs       3 500 CDF/kg       ✓ Enregistré                 │
│ 14:28 Riz        4 200 CDF/kg       ✓ Enregistré                 │
│ 13:50 USD/CDF    2 850              ✓ Enregistré                 │
├──────────────────────────────────────────────────────────────────┤
│ MON ACTIVITÉ                                                     │
│ Aujourd'hui        Cette semaine        Ce mois                  │
│ 21 soumissions     103 soumissions      387 soumissions          │
└──────────────────────────────────────────────────────────────────┘
```

---

# 25. Trader Dashboard

The trader dashboard should prioritize three actions:

```text
┌──────────────────────────────┐
│ 💰 Prix du jour              │
│ Consulter les prix du marché │
└──────────────────────────────┘

┌──────────────────────────────┐
│ 💱 Taux de change            │
│ Consulter les taux du jour   │
└──────────────────────────────┘

┌──────────────────────────────┐
│ 📝 Soumettre une réclamation │
│ Signaler un problème         │
└──────────────────────────────┘
```

Additional sections may include:

```text
Recent market prices
Exchange-rate summary
Nearby/available forex bureaus
Border information
Travel-document requirements
My recent claims
Important announcements
```

Make the trader interface mobile-friendly and easy to understand.

---

# 26. UX Requirement — Tip Card on Every Form

This is an important requirement.

**Every page containing a form must include a visible contextual tip/information card explaining how the user should fill in that form.**

Do not create forms without this UX guidance.

The tip card should appear near the form title or at the beginning of the form.

Use a reusable Blade component such as:

```text
resources/views/components/form-tip.blade.php
```

Possible usage:

```blade
<x-form-tip
    title="Comment remplir ce formulaire ?"
    :items="[
        'Sélectionnez le marché où le prix a été observé.',
        'Choisissez la marchandise concernée.',
        'Saisissez le prix exactement tel qu’il a été observé.',
        'Sélectionnez la devise utilisée par le vendeur.',
        'Vérifiez la date avant d’enregistrer.'
    ]"
/>
```

Visually, it should resemble:

```text
┌──────────────────────────────────────────────────────┐
│ 💡 Comment remplir ce formulaire ?                   │
│                                                      │
│ • Sélectionnez le marché concerné.                  │
│ • Choisissez la marchandise.                        │
│ • Saisissez le prix observé, sans conversion.       │
│ • Sélectionnez la devise utilisée.                  │
│ • Vérifiez la date avant d'enregistrer.             │
└──────────────────────────────────────────────────────┘
```

Use a modern information-card style.

Suggested characteristics:

```text
light background
subtle border
small information/light-bulb icon
short instructions
easy-to-read typography
responsive layout
```

Do not make the card visually overwhelming.

---

# 27. Form-Specific UX Tips

The text displayed by the tip card must be contextual.

Do not use the exact same generic message on every page.

## Commodity Price Form

```text
Comment enregistrer un prix ?

• Sélectionnez le marché où le prix a été observé.
• Choisissez la marchandise concernée.
• Saisissez le prix tel qu'il est vendu sur le marché.
• Sélectionnez la devise utilisée.
• Ne convertissez pas manuellement le prix dans une autre devise.
• Vérifiez l'unité de mesure.
• Vérifiez la date de collecte.
```

## Exchange Rate Form

```text
Comment enregistrer un taux de change ?

• Sélectionnez la devise de base.
• Sélectionnez la devise de destination.
• Exemple : 1 USD = 2 850 CDF.
• Dans ce cas, USD est la devise de base et CDF la devise de destination.
• Saisissez uniquement le taux observé.
• Indiquez la source du taux si elle est connue.
• Vérifiez la date avant d'enregistrer.
```

## Claim Form

```text
Comment soumettre une réclamation ?

• Choisissez le type de problème rencontré.
• Indiquez le lieu où le problème s'est produit.
• Décrivez clairement ce qui s'est passé.
• Ajoutez la date de l'incident si elle est connue.
• Vous pouvez joindre des photos ou documents justificatifs.
• Évitez de saisir des informations inutiles ou sans rapport avec la réclamation.
```

## Travel Document Form

```text
Comment ajouter un document de voyage ?

• Sélectionnez le pays concerné.
• Choisissez le type de document.
• Indiquez s'il est obligatoire.
• Ajoutez les conditions ou exigences applicables.
• Ajoutez les frais uniquement s'ils sont officiellement connus.
• Sélectionnez la devise correspondant aux frais.
• Fournissez des informations claires et à jour.
```

## Market Form

```text
Comment ajouter un marché ?

• Sélectionnez le pays.
• Saisissez le nom officiel ou couramment utilisé du marché.
• Indiquez la ville ou la localité.
• Ajoutez l'adresse lorsqu'elle est connue.
• Les coordonnées géographiques sont facultatives mais recommandées.
```

## User Form

```text
Comment créer un utilisateur ?

• Saisissez le nom complet de l'utilisateur.
• Utilisez une adresse e-mail ou un numéro de téléphone valide.
• Assignez uniquement les rôles nécessaires.
• Sélectionnez le ou les pays auxquels l'utilisateur peut accéder.
• Sélectionnez les marchés assignés lorsque cela est nécessaire.
```

---

# 28. Forms

All forms must:

- Have clear labels
- Show required fields clearly
- Display validation messages next to the appropriate field
- Preserve old values after validation failure
- Use appropriate input types
- Use searchable selects where useful
- Use date pickers for dates
- Use decimal input controls for monetary values
- Provide confirmation when a destructive action is attempted
- Disable submit buttons while an action is being submitted where appropriate
- Display success/error feedback
- Be responsive on mobile devices

Avoid excessively long forms.

Group fields into logical sections when needed.

---

# 29. Reusable Blade Components

Create reusable components for UI consistency.

Suggested components:

```text
<x-app-layout>
<x-sidebar>
<x-sidebar-section>
<x-sidebar-link>

<x-page-header>

<x-stat-card>

<x-form-tip>
<x-form-section>
<x-form-label>
<x-input-error>

<x-status-badge>

<x-data-table>

<x-empty-state>

<x-alert>

<x-confirm-dialog>

<x-country-selector>

<x-language-selector>
```

Avoid duplicating the same markup across many views.

---

# 30. Styling

Use a modern administrative dashboard style.

Avoid:

```text
heavy gradients
large pill-shaped buttons everywhere
excessive shadows
overly rounded interfaces
dense screens
```

Prefer:

```text
clean white/light surfaces
soft page background
subtle borders
6–10px border radius
consistent spacing
simple icons
clear typography
strong active navigation state
```

The sidebar should be approximately:

```text
240–260px
```

on desktop.

It should collapse appropriately on mobile.

Use simple icons, preferably from a consistent icon library.

---

# 31. Tables

All major management screens should support:

```text
search
pagination
sorting where useful
country filter
date filter where relevant
status filter where relevant
```

Examples:

```text
Commodity prices
Exchange rates
Claims
Markets
Users
Travel documents
```

Tables must show an empty-state component when no records exist.

---

# 32. Reports

Prepare reports for:

```text
Commodity prices by country
Commodity prices by market
Commodity price trends
Exchange-rate history
Exchange-rate trends
Claims by country
Claims by type
Claims by border crossing
Claims by status
Average claim-resolution time
Data collection completion
Collector activity
Missing commodity-price submissions
```

Filters should include relevant combinations of:

```text
country
market
commodity
currency
date range
claim status
claim type
```

---

# 33. Dashboard Service Layer

Do not perform large dashboard calculations directly inside Blade templates.

Create something such as:

```text
app/Services/DashboardService.php
```

Possible methods:

```php
todayPriceCount()
todayExchangeRateCount()
priceCollectionCompletion()
countryCollectionSummary()
latestExchangeRates()
commodityPriceTrends()
claimSummary()
overdueClaims()
missingSubmissions()
recentActivity()
```

Controllers should remain thin.

---

# 34. Service Layer

Use service classes for non-trivial business logic.

Examples:

```text
CommodityPriceService
ExchangeRateService
ClaimService
TravelDocumentService
DashboardService
CurrencyConversionService
```

Use database transactions where a process modifies multiple related records.

For example, creating a claim and the initial claim-status history should happen within one transaction.

---

# 35. Form Requests

Use Laravel Form Request classes instead of putting extensive validation directly in controllers.

Examples:

```text
StoreCommodityPriceRequest
UpdateCommodityPriceRequest

StoreExchangeRateRequest

StoreClaimRequest
UpdateClaimRequest

StoreTravelDocumentRequest

StoreMarketRequest

StoreUserRequest
```

---

# 36. Enums

Use PHP enums where the values represent a controlled business state.

Examples:

```text
ClaimStatus
BorderStatus
UserStatus
```

Example:

```php
enum ClaimStatus: string
{
    case Submitted = 'submitted';
    case UnderReview = 'under_review';
    case Pending = 'pending';
    case Resolved = 'resolved';
    case Rejected = 'rejected';
    case Closed = 'closed';
}
```

Cast the model field to the enum.

---

# 37. Auditability

Important operations should record:

```text
who created the record
when it was created
who updated it
when it was updated
```

For collection-related data, use fields such as:

```text
created_by
updated_by
```

where appropriate.

For claims, maintain status history.

Do not destroy useful historical data merely because a new value is recorded.

For example:

```text
new commodity price -> new price history row

new exchange rate -> new exchange-rate history row
```

rather than overwriting yesterday's value.

---

# 38. Query Performance

Add indexes to fields frequently used in filters and joins.

Examples:

```text
country_id
market_id
commodity_id
currency_id
price_date
rate_date
status
claim_type_id
created_by
```

Use eager loading to avoid N+1 queries.

Example:

```php
CommodityPrice::with([
    'commodity.translations',
    'market.country',
    'currency',
    'creator',
])
```

Use pagination for large datasets.

---

# 39. Security

Use:

```text
CSRF protection
Form Request validation
Policies
Permissions
Rate limiting where appropriate
Secure file validation
Secure file storage
Escaped output
Authenticated routes
Authorization checks
```

A Country Admin must never be able to manipulate another country's record simply by changing a URL or request payload.

Always enforce authorization server-side.

Do not rely only on hiding menu items.

---

# 40. API-Ready Architecture

Even if the initial UI uses Blade, organize the business logic so the same Laravel backend can later support:

```text
mobile app
Android app
public API
USSD integration
SMS integration
WhatsApp integration
public trader portal
```

Do not put important business logic exclusively inside Blade controllers.

---

# 41. Low-Bandwidth UX

The trader-facing interface should be lightweight.

Avoid unnecessary JavaScript and very large assets.

Prioritize:

```text
fast loading
simple navigation
mobile responsiveness
clear buttons
large touch targets
readable typography
minimal steps
```

Important trader actions should be reachable quickly:

```text
Prix du jour
Taux de change
Documents de voyage
Soumettre une réclamation
```

---

# 42. Application Language

The initial administrative UI should primarily use **French**.

Examples:

```text
Dashboard -> Tableau de bord
Markets -> Marchés
Commodities -> Marchandises
Daily Prices -> Prix journaliers
Exchange Rates -> Taux de change
Forex Bureaus -> Bureaux de change
Border Crossings -> Postes frontaliers
Travel Documents -> Documents de voyage
Claims -> Réclamations
Claim Types -> Types de réclamations
Countries -> Pays
Languages -> Langues
Currencies -> Devises
Measurement Units -> Unités de mesure
Commodity Categories -> Catégories de marchandises
Users -> Utilisateurs
Roles & Permissions -> Rôles et autorisations
Reports -> Rapports
Contact Persons -> Personnes de contact
Settings -> Paramètres
```

However, keep the Laravel internationalization structure ready for additional interface languages.

Use translation files rather than hardcoding every UI label throughout Blade templates.

---

# 43. Implementation Sequence

Work progressively.

Do not attempt to implement everything in one giant file.

Proceed in this order:

1. Review the existing Laravel application's structure and dependencies.
2. Design database migrations and relationships.
3. Create countries, languages, and currencies.
4. Configure users, roles, permissions, and policies.
5. Build markets and border crossings.
6. Build measurement units and commodity categories.
7. Build commodities and translations.
8. Build commodity price collection.
9. Build exchange-rate collection.
10. Build forex bureaus.
11. Build travel documents.
12. Build claims and claim workflow.
13. Build contact persons.
14. Build role-aware sidebar navigation.
15. Build the Super Admin dashboard.
16. Build the Country Admin dashboard.
17. Build the Data Collector dashboard.
18. Build the Trader dashboard.
19. Build reports.
20. Improve responsive/mobile UX.
21. Add tests for critical permissions and workflows.

After each major module, explain:

```text
what files were created
what relationships were created
what routes were added
what permissions were added
how the feature works
```

---

# 44. Important Coding Instructions

Follow Laravel conventions.

Prefer:

```text
Eloquent relationships
Form Requests
Policies
Services
Enums
Blade components
Route model binding
Database transactions
Named routes
Dependency injection
```

Avoid:

```text
fat controllers
huge Blade files
raw SQL when Eloquent/query builder is sufficient
hardcoded role checks everywhere
duplicated form markup
duplicated translation fields
business logic inside views
```

Keep code maintainable and production-oriented.

---

# 45. Testing

Create tests for critical workflows, especially authorization.

At minimum test:

```text
Super Admin can access all countries

Country Admin cannot access unauthorized countries

Data Collector can create commodity prices

Data Collector cannot manage users

Trader cannot access administration routes

Trader can create their own claim

Trader cannot view another trader's private claim

Claim Officer can review claims

Commodity price history is preserved

Exchange-rate history is preserved

Duplicate daily price validation works correctly

Unauthorized direct URL access is rejected
```

---

# 46. Final UX Principle

For every screen ask:

> What is the primary task the user came here to accomplish?

Do not make dashboards or forms unnecessarily complicated.

For administrators, prioritize monitoring and exceptions.

For collectors, prioritize missing data and quick data entry.

For traders, prioritize accessing today's useful information quickly.

For claim officers, prioritize unresolved claims and workflow.

Most importantly:

**Every form must include a contextual tip card telling the user how to fill it correctly.**

This requirement should be implemented as a reusable component throughout PAHEWO rather than manually redesigned on every page.

---

# 47. Existing Project Safety

Before modifying the application:

1. Inspect the existing Laravel project structure.
2. Identify the current authentication setup.
3. Identify existing layouts, middleware, packages, migrations, routes, models, and UI components.
4. Reuse existing infrastructure where practical.
5. Do not overwrite or remove working functionality without a clear reason.
6. Integrate PAHEWO incrementally.
7. If an existing implementation conflicts with the requested architecture, explain the conflict before replacing it.
8. Preserve existing data and migrations.
9. Prefer additive migrations over destructive schema changes.
10. Keep changes easy to review and test.
