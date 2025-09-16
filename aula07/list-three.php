<?php
abstract class Payment {
    protected $amount;
    protected $currency;
    
    public function __construct($amount, $currency = 'BRL') {
        $this->amount = $amount;
        $this->currency = $currency;
    }
    
    abstract public function process();
    
    public function getPaymentDetails() {
        return "Valor: {$this->amount} {$this->currency}";
    }
    
    public function getAmount() {
        return $this->amount;
    }
    
    public function getCurrency() {
        return $this->currency;
    }
}

class CardPayment extends Payment {
    private $cardNumber;
    private $cardHolder;
    private $expiryDate;
    private $cvv;
    
    public function __construct($amount, $cardNumber, $cardHolder, $expiryDate, $cvv, $currency = 'BRL') {
        parent::__construct($amount, $currency);
        $this->cardNumber = $cardNumber;
        $this->cardHolder = $cardHolder;
        $this->expiryDate = $expiryDate;
        $this->cvv = $cvv;
    }
    
    public function process() {
        $transactionId = 'CARD_' . uniqid();
        return [
            'status' => 'success',
            'message' => 'Pagamento com cartão processado com sucesso!',
            'transaction_id' => $transactionId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'card_last_digits' => substr($this->cardNumber, -4)
        ];
    }
    
    public function getPaymentDetails() {
        $details = parent::getPaymentDetails();
        return $details . " | Método: Cartão | Cartão: ****" . substr($this->cardNumber, -4);
    }
}

class PixPayment extends Payment {
    private $pixKey;
    private $pixType;
    
    public function __construct($amount, $pixKey, $pixType = 'CPF', $currency = 'BRL') {
        parent::__construct($amount, $currency);
        $this->pixKey = $pixKey;
        $this->pixType = $pixType;
    }
    
    public function process() {
        $transactionId = 'PIX_' . uniqid();
        return [
            'status' => 'success',
            'message' => 'Pagamento via PIX realizado!',
            'transaction_id' => $transactionId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'pix_key' => $this->pixKey,
            'pix_type' => $this->pixType
        ];
    }
    
    public function getPaymentDetails() {
        $details = parent::getPaymentDetails();
        return $details . " | Método: PIX | Chave: {$this->pixKey}";
    }
}

class BoletoPayment extends Payment {
    private $barcode;
    private $dueDate;
    
    public function __construct($amount, $dueDate = null, $currency = 'BRL') {
        parent::__construct($amount, $currency);
        $this->barcode = $this->generateBarcode();
        $this->dueDate = $dueDate ?: date('Y-m-d', strtotime('+3 days'));
    }
    
    private function generateBarcode() {
        return '23793.38128 60000.000005 00000.000009 8 836100000' . $this->amount;
    }
    
    public function process() {
        return [
            'status' => 'pending',
            'message' => 'Boleto gerado com sucesso. Aguardando pagamento.',
            'barcode' => $this->barcode,
            'due_date' => $this->dueDate,
            'amount' => $this->amount,
            'currency' => $this->currency
        ];
    }
    
    public function getPaymentDetails() {
        $details = parent::getPaymentDetails();
        return $details . " | Método: Boleto | Vencimento: {$this->dueDate}";
    }
}

class PaymentProcessor {
    public static function executePayment(Payment $payment) {
        $result = $payment->process();
        
        echo "<div style='border:1px solid #ccc; padding:10px; margin:10px; border-radius:8px;'>";
        echo "<h3>Detalhes do Pagamento</h3>";
        echo "<p><strong>{$payment->getPaymentDetails()}</strong></p>";
        
        echo "<ul>";
        echo "<li>Status: <strong>{$result['status']}</strong></li>";
        echo "<li>Mensagem: {$result['message']}</li>";
        
        if (isset($result['transaction_id'])) {
            echo "<li>ID da Transação: {$result['transaction_id']}</li>";
        }
        if (isset($result['barcode'])) {
            echo "<li><strong>Boleto:</strong> {$result['barcode']}</li>";
            echo "<li>Vencimento: {$result['due_date']}</li>";
        }
        if (isset($result['pix_key'])) {
            echo "<li>Chave PIX: {$result['pix_key']} ({$result['pix_type']})</li>";
        }
        echo "</ul>";
        
        echo "</div>";
        
        return $result;
    }
    
    public static function processMultiplePayments(array $payments) {
        $results = [];
        foreach ($payments as $payment) {
            $results[] = self::executePayment($payment);
        }
        return $results;
    }
}

// Testes
$cardPayment = new CardPayment(99.99, '666333333333333', 'George Russel', '06/24', '456');
$pixPayment = new PixPayment(50.00, 'george.russel@mercedes.com', 'EMAIL');
$boletoPayment =  new BoletoPayment(125.00, date('Y-m-d', strtotime('+5 days')));

echo "<h2>Pagamentos Individuais</h2>";
PaymentProcessor::executePayment($cardPayment);
PaymentProcessor::executePayment($pixPayment);
PaymentProcessor::executePayment($boletoPayment);

echo "<h2>Vários Pagamentos</h2>";
$payments = [$cardPayment, $pixPayment, $boletoPayment];
PaymentProcessor::processMultiplePayments($payments);
?>
