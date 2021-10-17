<?php

namespace DNT\Translate\Controllers;

use App\Http\Controllers\Controller;
use DNT\Translate\Actions\ChangeLocale;
use DNT\Translate\Contracts\Locator;
use DNT\Translate\Requests\CheckLocaleRequest;
use Illuminate\Http\RedirectResponse;
use RuntimeException;

class LocalizationController extends Controller
{

    public function changeLocale(CheckLocaleRequest $request, $locale = null): RedirectResponse
    {
        try {
            $locale = $locale ?: app(Locator::class)->getLocaleSupportDiffCurrent()[0];
            app(ChangeLocale::class)->setLocale($locale);
        } catch (RuntimeException $exception) {
            return back()->with('error', __('localization::locator.changeLocaleFail'));
        }

        return back()->with('error', __('localization::locator.changeLocaleSuccess'));

    }
}
