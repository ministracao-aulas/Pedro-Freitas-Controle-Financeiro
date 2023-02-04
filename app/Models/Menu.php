<?php

namespace App\Models;

use App\Enums\MenuEnum;
use TiagoF2\Enums\HasEnum;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int|null $type_enum
 * @property string|null $url
 * @property string|null $icon
 * @property string|null $class
 * @property string|null $label
 * @property mixed|null $can
 * @property string|null $route
 * @property mixed|null $active_if_route_in
 * @property int|null $parent_id
 * @property int|null $relative_position
 * @property bool|null $active
 * @property int|null $show_only_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $type
 * @property-read Menu|null $parentMenu
 * @property-read \App\Models\User|null $showOnlyTo
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereActiveIfRouteIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereRelativePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereShowOnlyTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTypeEnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUrl($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    use HasFactory;
    use HasEnum;

    protected $fillable = [
        'identifier',
        'type_enum',
        'url',
        'icon',
        'class',
        'label',
        'can',
        'custom_menu_rule',
        'route',
        'active_if_route_in',
        'parent_id',
        'relative_position',
        'active',
        'show_only_to',
    ];

    protected $casts = [
        'can' => AsCollection::class,
        'custom_menu_rule' => AsCollection::class,
        'active_if_route_in' => AsCollection::class,
        'active' => 'boolean',
    ];

    protected $appends = [
        'type'
    ];

    protected $enumClass = MenuEnum::class;

    /**
     * Get the showOnlyTo associated with the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function showOnlyTo(): HasOne
    {
        return $this->hasOne(User::class, 'show_only_to', 'id');
    }

    /**
     * Get the parent Menu associated with the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentMenu(): HasOne
    {
        return $this->hasOne(Menu::class, 'parent_id', 'id');
    }

    public function getTypeAttribute()
    {
        if (is_null($this->type_enum) || !static::enumSafe()) {
            return null;
        }

        return static::enumSafe()->getValue($this->type_enum, false);
    }

    /**
     * function allAvailableMenu
     *
     * @param null|User $user
     *
     * @return array|null|Collection
     */
    public static function allAvailableMenu(?User $user = null)
    {
        /**
         * TODO: validate user permissions
         * TODO : Cached return
         */

        if ($user) {
            return $user->availableMenu();
        }

        return Cache::remember(
            __METHOD__,
            3600 /*secs*/,
            fn () => static::whereActive(true)->get()
        );
    }

    /**
     * function toShow
     *
     * @param bool $toShow
     * @return bool
     */
    public static function toShow(bool $toShow = true): bool
    {
        return $toShow;
    }

    /**
     * function toHide
     *
     * @param bool $toHide
     * @return bool
     */
    public static function toHide(bool $toHide = true): bool
    {
        return !$toHide;
    }

    /**
     * function clearAllCachedMenu
     *
     * @return void
     */
    public static function clearAllCachedMenu(): void
    {
        /**
         * TODO: Chamar esse método ao atualizar X item do menu
         */
        /**
         * O ideal aqui, seria limpar apenas os caches relacionados aos menus
         * Uma forma seria trabalhar com cache por tags
         * Para isso o 'cache driver' precisa aceitar tags (exemplo redis)
         * https://laravel.com/docs/cache#cache-tags
         *
         * Podemos futuramente verificar aqui se o driver do cache é X ou Y e executar um ou outro comando
         */

        Cache::flush();
    }

    /**
     * function clearCachedMenu
     *
     * @param string ...$cacheKeys
     *
     * @return void
     */
    public static function clearCachedMenu(string ...$cacheKeys): void
    {
        if (!$cacheKeys) {
            static::clearAllCachedMenu();

            return;
        }

        foreach ($cacheKeys as $cacheKey) {
            if (!\is_string($cacheKey) || !\trim($cacheKey)) {
                continue;
            }

            Cache::forget($cacheKey);
        }
    }
}
