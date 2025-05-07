<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class SensorAlertNotification extends Notification
{
    use Queueable;

    protected $sensorData;
    protected $measurementType;

    public function __construct($sensorData, $measurementType)
    {
        $this->sensorData = $sensorData;
        $this->measurementType = $measurementType;
    }

    public function via($notifiable)
    {
        return ['mail']; // Only 'mail', we send Telegram manually inside toMail()
    }

    public function toMail($notifiable)
    {
        $this->sendTelegramMessage($notifiable); // 👈 Manually send telegram here

        $mail = (new MailMessage)
            ->subject('🚨 Sensor Alert - ' . ucfirst($this->measurementType));

        if ($this->measurementType === 'Temperature') {
            $mail->line('Temperature too high: ' . $this->sensorData['max_temp'] . '°C')
                ->line('Variance: ' . $this->sensorData['variance_percent'] . '%')
                ->line('Sensor: ' . $this->sensorData['sensor_name'])
                ->line('Substation: ' . $this->sensorData['substation'])
                ->line('Panel: ' . $this->sensorData['panel'])
                ->line('Compartment: ' . $this->sensorData['compartment']);
        } elseif ($this->measurementType === 'Partial Discharge') {
            $mail->line('Partial Discharge detected: Level ' . $this->sensorData['discharge_level'])
                ->line('Sensor: ' . $this->sensorData['sensor_name'])
                ->line('Substation: ' . $this->sensorData['substation'])
                ->line('Panel: ' . $this->sensorData['panel'])
                ->line('Compartment: ' . $this->sensorData['compartment']);
        }

        return $mail;
    }

    protected function sendTelegramMessage($notifiable)
    {
        $text = "🚨 *Sensor Alert* - " . ucfirst($this->measurementType) . "\n";

        if ($this->measurementType === 'Temperature') {
            $text .= "Substation: {$this->sensorData['substation']}\n";
            $text .= "Panel: {$this->sensorData['panel']}\n";
            $text .= "Compartment: {$this->sensorData['compartment']}\n";
            $text .= "Sensor: {$this->sensorData['sensor_name']}\n";
            $text .= "Temperature: {$this->sensorData['max_temp']}°C\n";
            $text .= "Variance: {$this->sensorData['variance_percent']}%\n";
            $text .= "Status: *" . strtoupper($this->sensorData['alert_level']) . "*";
        } elseif ($this->measurementType === 'Partial Discharge') {
            $text .= "Substation: {$this->sensorData['substation']}\n";
            $text .= "Panel: {$this->sensorData['panel']}\n";
            $text .= "Compartment: {$this->sensorData['compartment']}\n";
            $text .= "Sensor: {$this->sensorData['sensor_name']}\n";
            $text .= "Partial Discharge Level: {$this->sensorData['discharge_level']}\n";
            $text .= "Status: *" . strtoupper($this->sensorData['alert_level']) . "*";
        }

        $url = 'https://api.telegram.org/bot' . config('services.telegram.bot_token') . '/sendMessage';
        Log::info('Telegram POST URL: ' . $url);

        try {
            $response = Http::post('https://api.telegram.org/bot' . config('services.telegram.bot_token') . '/sendMessage', [
                'chat_id' => $notifiable->chat_id,
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to send message to Telegram');
            }
        } catch (\Exception $e) {
            Log::error('Telegram message error: ' . $e->getMessage());
        }

        Log::info('Telegram response:', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

    }
}
