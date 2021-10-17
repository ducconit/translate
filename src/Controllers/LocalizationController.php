<?php

namespace DNT\Translate\Controllers;

use App\Http\Controllers\Controller;
use DNT\Translate\Actions\ChangeLocale;
use DNT\Translate\Contracts\Locator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class LocalizationController extends Controller
{

    public function changeLocale($locale = null): RedirectResponse
    {
        try {
            $locale = $locale ?: app(Locator::class)->getLocaleSupportDiffCurrent()[0];
            Validator::make(['locale' => $locale], [
                'locale' => 'locale'
            ])->validate();
            app(ChangeLocale::class)->setLocale($locale);
        } catch (RuntimeException $exception) {
            return back()->with('error', __('localization::locator.changeLocaleFail'));
        }

        return back()->with('error', __('localization::locator.changeLocaleSuccess'));

    }
}
