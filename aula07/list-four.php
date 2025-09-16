<?php
abstract class Notification {
    protected $recipient;
    protected $message;
    protected $timestamp;
    
    public function __construct($recipient, $message) {
        $this->recipient = $recipient;
        $this->message = $message;
        $this->timestamp = date('Y-m-d H:i:s');
    }
    
    abstract public function send();
    
    public function getNotificationInfo() {
        return "Destinatário: {$this->recipient} | Mensagem: {$this->message} | Hora: {$this->timestamp}";
    }
    
    public function getRecipient() {
        return $this->recipient;
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function getTimestamp() {
        return $this->timestamp;
    }
    
    public final function processNotification() {
        $this->validate();
        $this->formatMessage();
        $result = $this->send();
        return $result;
    }
    
    protected function validate() {
        if (empty($this->recipient)) {
            throw new InvalidArgumentException("Recipient cannot be empty");
        }
        if (empty($this->message)) {
            throw new InvalidArgumentException("Message cannot be empty");
        }
        return true;
    }
    
    protected function formatMessage() {
        $this->message = trim($this->message);
    }
}

class Email extends Notification {
    private $subject;
    private $from;
    private $cc;
    
    public function __construct($recipient, $subject, $message, $from = 'noreply@example.com', $cc = []) {
        parent::__construct($recipient, $message);
        $this->subject = $subject;
        $this->from = $from;
        $this->cc = $cc;
    }
    
    public function send() {
        $messageId = uniqid('email_');
        return [
            'status' => 'success',
            'message' => 'E-mail enviado com sucesso!',
            'message_id' => $messageId,
            'recipient' => $this->recipient,
            'subject' => $this->subject,
            'from' => $this->from
        ];
    }
    
    protected function validate() {
        parent::validate();
        if (!filter_var($this->recipient, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("E-mail inválido: " . $this->recipient);
        }
        if (empty($this->subject)) {
            throw new InvalidArgumentException("O assunto do e-mail não pode estar vazio");
        }
        return true;
    }
    
    protected function formatMessage() {
        parent::formatMessage();
        $this->message = "<html><body>" . nl2br(htmlspecialchars($this->message)) . "</body></html>";
    }
    
    public function getNotificationInfo() {
        $info = parent::getNotificationInfo();
        return $info . " | Tipo: E-mail | Assunto: {$this->subject}";
    }
}

class SMS extends Notification {
    private $senderId;
    
    public function __construct($recipient, $message, $senderId = 'SERVICE') {
        parent::__construct($recipient, $message);
        $this->senderId = $senderId;
    }
    
    public function send() {
        $messageId = uniqid('sms_');
        return [
            'status' => 'success',
            'message' => 'SMS enviado com sucesso!',
            'message_id' => $messageId,
            'recipient' => $this->recipient,
            'sender_id' => $this->senderId
        ];
    }
    
    protected function validate() {
        parent::validate();
        if (!preg_match('/^\+?[0-9]{10,15}$/', $this->recipient)) {
            throw new InvalidArgumentException("Número inválido: " . $this->recipient);
        }
        return true;
    }
    
    protected function formatMessage() {
        parent::formatMessage();
        if (strlen($this->message) > 160) {
            $this->message = substr($this->message, 0, 157) . '...';
        }
    }
    
    public function getNotificationInfo() {
        $info = parent::getNotificationInfo();
        return $info . " | Tipo: SMS | Remetente: {$this->senderId}";
    }
}

class Push extends Notification {
    private $deviceToken;
    private $title;
    private $badge;
    private $sound;
    
    public function __construct($deviceToken, $title, $message, $badge = 1, $sound = 'default') {
        parent::__construct($deviceToken, $message);
        $this->deviceToken = $deviceToken;
        $this->title = $title;
        $this->badge = $badge;
        $this->sound = $sound;
    }
    
    public function send() {
        $messageId = uniqid('push_');
        return [
            'status' => 'success',
            'message' => 'Push enviado com sucesso!',
            'message_id' => $messageId,
            'device_token' => $this->deviceToken,
            'title' => $this->title,
            'badge' => $this->badge
        ];
    }
    
    protected function validate() {
        parent::validate();
        if (empty($this->title)) {
            throw new InvalidArgumentException("Título do push não pode estar vazio");
        }
        if (strlen($this->deviceToken) < 20) {
            throw new InvalidArgumentException("Token inválido: " . $this->deviceToken);
        }
        return true;
    }
    
    public function getNotificationInfo() {
        $info = parent::getNotificationInfo();
        return $info . " | Tipo: Push | Título: {$this->title}";
    }
}

class NotificationManager {
    public static function sendNotification(Notification $notification) {
        try {
            $result = $notification->processNotification();
            
            echo "<div style='border:1px solid #ccc; padding:10px; margin:10px; border-radius:8px;'>";
            echo "<h3>Notificação</h3>";
            echo "<p><strong>" . $notification->getNotificationInfo() . "</strong></p>";
            
            echo "<ul>";
            echo "<li>Status: <strong>{$result['status']}</strong></li>";
            echo "<li>Mensagem: {$result['message']}</li>";
            if (isset($result['message_id'])) {
                echo "<li>ID: {$result['message_id']}</li>";
            }
            echo "</ul>";
            echo "</div>";
            
            return $result;
        } catch (Exception $e) {
            echo "<div style='border:1px solid red; padding:10px; margin:10px; border-radius:8px; background:#ffe6e6;'>";
            echo "<h3>Erro</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "</div>";
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public static function sendBulkNotifications(array $notifications) {
        $results = [];
        foreach ($notifications as $notification) {
            $results[] = self::sendNotification($notification);
        }
        return $results;
    }
}

$emailNotification = new Email('user@example.com', 'Bem-vindo!', 'Obrigado por se cadastrar!');
$smsNotification = new SMS('+5511999999999', 'Seu código é 123456');
$pushNotification = new Push('device_token_1234567890abcdefg1234567', 'Nova Mensagem', 'Você recebeu uma nova mensagem!');

echo "<h2>Enviando Notificações</h2>";
NotificationManager::sendNotification($emailNotification);
NotificationManager::sendNotification($smsNotification);
NotificationManager::sendNotification($pushNotification);
?>
