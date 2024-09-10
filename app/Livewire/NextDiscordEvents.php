<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

/**
 * @phpstan-type DiscordEvent array{
 *     name: string,
 *     image?: string,
 *     description?: string,
 *     scheduled_start_time: string,
 *     scheduled_end_time: string,
 *     entity_metadata?: array{
 *         location?: string,
 *     },
 * }
 */
class NextDiscordEvents extends Component
{
    public function mount()
    {
    }

    public function render()
    {
        $id = config('services.discord.guild_id');
        $token = config('services.discord.bot_token');

        /** @var DiscordEvent[] $events */
        $events = Cache::remember('discord_events', now()->addMinutes(5), function () use ($id, $token) {
            return Http::withToken($token, 'Bot')
                ->accept('application/json')
                ->get(sprintf('https://discord.com/api/guilds/%s/scheduled-events', $id))
                ->json();
        });

        // todo: sort events by start time?
        // todo: show recurrences

        return View::make('livewire.next-discord-events', [
            'event' => count($events) > 0 ? $events[0] : null,
        ]);
    }
}
