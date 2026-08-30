<?php

use App\Http\Controllers\BorderCrossingController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ClaimTypeController;
use App\Http\Controllers\CommodityCategoryController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\CommodityPriceController;
use App\Http\Controllers\ContactPersonController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CurrencyConverterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\ForexBureauController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LanguagePreferenceController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\PriceCompareController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TravelDocumentController;
use App\Http\Controllers\TravelRequirementsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pahewo/language', [LanguagePreferenceController::class, 'edit'])->name('pahewo.language');
    Route::put('/pahewo/language', [LanguagePreferenceController::class, 'update'])->name('pahewo.language.update');

    Route::prefix('pahewo')->name('pahewo.')->middleware('country.access')->group(function (): void {
        Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics');
        Route::get('prices/compare', [PriceCompareController::class, 'index'])->name('prices.compare');
        Route::match(['get', 'post'], 'currency-converter', [CurrencyConverterController::class, 'index'])->name('currency-converter');
        Route::get('travel-requirements', [TravelRequirementsController::class, 'index'])->name('travel-requirements');
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/price-trends', [ReportController::class, 'priceTrends'])->name('reports.price-trends');
        Route::get('reports/exchange-rate-trends', [ReportController::class, 'exchangeRateTrends'])->name('reports.exchange-rate-trends');
        Route::get('reports/claims', [ReportController::class, 'claims'])->name('reports.claims');
        Route::get('submissions', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('submissions/history', [SubmissionController::class, 'history'])->name('submissions.history');
        Route::get('help', [HelpController::class, 'index'])->name('help');
        Route::get('settings', [SettingsController::class, 'index'])->name('settings');

        Route::resource('countries', CountryController::class)->except(['show']);
        Route::resource('markets', MarketController::class)->except(['show']);
        Route::resource('commodities', CommodityController::class)->except(['show']);
        Route::resource('commodity-prices', CommodityPriceController::class)->except(['show'])->parameters([
            'commodity-prices' => 'commodityPrice',
        ]);
        Route::resource('exchange-rates', ExchangeRateController::class)->except(['show'])->parameters([
            'exchange-rates' => 'exchangeRate',
        ]);
        Route::resource('forex-bureaus', ForexBureauController::class)->except(['show'])->parameters([
            'forex-bureaus' => 'forexBureau',
        ]);
        Route::resource('border-crossings', BorderCrossingController::class)->except(['show'])->parameters([
            'border-crossings' => 'borderCrossing',
        ]);
        Route::resource('claims', ClaimController::class);
        Route::resource('claim-types', ClaimTypeController::class)->except(['show'])->parameters([
            'claim-types' => 'claimType',
        ]);
        Route::resource('travel-documents', TravelDocumentController::class)->except(['show'])->parameters([
            'travel-documents' => 'travelDocument',
        ]);
        Route::resource('contact-persons', ContactPersonController::class)->except(['show'])->parameters([
            'contact-persons' => 'contactPerson',
        ]);
        Route::resource('languages', LanguageController::class)->except(['show']);
        Route::resource('currencies', CurrencyController::class)->except(['show']);
        Route::resource('measurement-units', MeasurementUnitController::class)->except(['show'])->parameters([
            'measurement-units' => 'measurementUnit',
        ]);
        Route::resource('commodity-categories', CommodityCategoryController::class)->except(['show'])->parameters([
            'commodity-categories' => 'commodityCategory',
        ]);
        Route::resource('users', UserController::class)->except(['show']);
    });
});

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
