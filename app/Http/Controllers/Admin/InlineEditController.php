<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InlineEditController extends Controller
{
    protected array $modelMap = [
        'about'      => \App\Models\About::class,
        'consulting' => \App\Models\Consulting::class,
        'city'       => \App\Models\City::class,
        'document'   => \App\Models\Document::class,
        'important'  => \App\Models\Important::class,
        'law'        => \App\Models\Law::class,
        'news'       => \App\Models\News::class,
        'online'     => \App\Models\Online::class,
        'partner'    => \App\Models\Partner::class,
        'schedule'   => \App\Models\Schedule::class,
        'seminar'    => \App\Models\Seminar::class,
        'team'       => \App\Models\Team::class,
        'training'   => \App\Models\Training::class,
        'useful'     => \App\Models\Useful::class,
    ];

    protected array $allowedFields = [
        'desc', 'html', 'desc2', 'html2', 'short_desc',
    ];

    public function update(Request $request): JsonResponse
    {
        if (! auth('moonshine')->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'model' => 'required|string',
            'id'    => 'required|integer|min:1',
            'field' => 'required|string',
            'value' => 'nullable|string',
        ]);

        $alias = $request->input('model');
        $field = $request->input('field');

        if (! array_key_exists($alias, $this->modelMap)) {
            return response()->json(['error' => 'Model not allowed'], 403);
        }

        if (! in_array($field, $this->allowedFields, true)) {
            return response()->json(['error' => 'Field not allowed'], 403);
        }

        $modelClass = $this->modelMap[$alias];
        $item = $modelClass::findOrFail((int) $request->input('id'));
        $item->$field = $request->input('value');
        $item->save();

        return response()->json(['success' => true]);
    }
}
