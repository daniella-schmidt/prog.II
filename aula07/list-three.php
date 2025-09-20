<?php
/**
 * Classe abstrata base para todos os tipos de pagamento
 * Define a interface comum que todas as subclasses devem implementar
 */
abstract class Payment {
    protected $amount;
    protected $currency;
    
    //Construtor da classe 
    public function __construct($amount, $currency = 'BRL') {
        if (!is_numeric($amount) || $amount <= 0) {
            throw new InvalidArgumentException("Valor de pagamento deve ser numérico e positivo");
        }
        
        if (strlen($currency) !== 3) {
            throw new InvalidArgumentException("Código da moeda deve ter 3 caracteres");
        }
        
        $this->amount = (float) $amount;
        $this->currency = strtoupper($currency);
    }
    
    // Método abstrato que deve ser implementado pelas subclasses
    abstract public function process();
    
    // Retorna os detalhes do pagamento
    public function getPaymentDetails() {
        return "Valor: {$this->amount} {$this->currency}";
    }
    
    // Obtém o valor do pagamento
    public function getAmount() {
        return $this->amount;
    }
    
    // Obtém a moeda do pagamento
    public function getCurrency() {
        return $this->currency;
    }
}

// Classe para pagamentos com cartão de crédito/débito
class CardPayment extends Payment {
    private $cardNumber;
    private $cardHolder;
    private $expiryDate;
    private $cvv;
    
    // Construtor da classe CardPayment
    public function __construct($amount, $cardNumber, $cardHolder, $expiryDate, $cvv, $currency = 'BRL') {
        parent::__construct($amount, $currency);
        
        // Validação do número do cartão
        if (!preg_match('/^[0-9]{13,19}$/', str_replace(' ', '', $cardNumber))) {
            throw new InvalidArgumentException("Número do cartão inválido");
        }
        
        // Validação do nome do titular
        if (empty(trim($cardHolder))) {
            throw new InvalidArgumentException("Nome do titular não pode estar vazio");
        }
        
        // Validação da data de expiração
        if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $expiryDate)) {
            throw new InvalidArgumentException("Data de expiração inválida. Use o formato MM/AA");
        }
        
        // Validação do CVV
        if (!preg_match('/^[0-9]{3,4}$/', $cvv)) {
            throw new InvalidArgumentException("CVV inválido. Deve conter 3 ou 4 dígitos");
        }
        
        $this->cardNumber = $cardNumber;
        $this->cardHolder = $cardHolder;
        $this->expiryDate = $expiryDate;
        $this->cvv = $cvv;
    }
    
    // Processa o pagamento com cartão
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
    
    // Retorna os detalhes do pagamento com cartão
    public function getPaymentDetails() {
        $details = parent::getPaymentDetails();
        return $details . " | Método: Cartão | Cartão: ****" . substr($this->cardNumber, -4);
    }
}

// Classe para pagamentos via PIX
class PixPayment extends Payment {
    private $pixKey;
    private $pixType;
    
    // Construtor da classe PixPayment
    public function __construct($amount, $pixKey, $pixType = 'CPF', $currency = 'BRL') {
        parent::__construct($amount, $currency);
        
        // Validação da chave PIX
        if (empty(trim($pixKey))) {
            throw new InvalidArgumentException("Chave PIX não pode estar vazia");
        }
        
        // Validação do tipo PIX
        $validTypes = ['CPF', 'CNPJ', 'EMAIL', 'PHONE', 'RANDOM'];
        if (!in_array(strtoupper($pixType), $validTypes)) {
            throw new InvalidArgumentException("Tipo de chave PIX inválido. Use: " . implode(', ', $validTypes));
        }
        
        $this->pixKey = $pixKey;
        $this->pixType = strtoupper($pixType);
    }
    
    //Processa o pagamento via PIX
    public function process() {
        // Simula processamento PIX
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
    
    // Retorna os detalhes do pagamento PIX
    public function getPaymentDetails() {
        $details = parent::getPaymentDetails();
        return $details . " | Método: PIX | Chave: {$this->pixKey}";
    }
}

//Classe para pagamentos com boleto bancário
class BoletoPayment extends Payment {
    private $barcode;
    private $dueDate;
    
    // Construtor da classe BoletoPayment
    public function __construct($amount, $dueDate = null, $currency = 'BRL') {
        parent::__construct($amount, $currency);
        
        // Validação da data de vencimento
        if ($dueDate !== null) {
            $parsedDate = date_parse_from_format('Y-m-d', $dueDate);
            if (!$parsedDate || $parsedDate['error_count'] > 0 || !checkdate($parsedDate['month'], $parsedDate['day'], $parsedDate['year'])) {
                throw new InvalidArgumentException("Data de vencimento inválida. Use o formato YYYY-MM-DD");
            }
            $this->dueDate = $dueDate;
        } else {
            $this->dueDate = date('Y-m-d', strtotime('+3 days'));
        }
        
        $this->barcode = $this->generateBarcode();
    }

    // Gera um código de barras simulado para o boleto
    private function generateBarcode() {
        return '23793.38128 60000.000005 00000.000009 8 836100000' . str_pad($this->amount * 100, 10, '0', STR_PAD_LEFT);
    }
    
    // Processa a geração do boleto
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
    
    // Retorna os detalhes do pagamento com boleto
    public function getPaymentDetails() {
        $details = parent::getPaymentDetails();
        return $details . " | Método: Boleto | Vencimento: {$this->dueDate}";
    }
}

// Classe para processamento de pagamentos
class PaymentProcessor {
    public static function executePayment(Payment $payment) {
        $result = $payment->process();
        
        echo "<div style='border:1px solid #ccc; padding:15px; margin:15px; border-radius:8px; background:#f9f9f9;'>";
        echo "<h3 style='margin-top:0; color:#333;'>Detalhes do Pagamento</h3>";
        echo "<p style='margin:8px 0;'><strong>{$payment->getPaymentDetails()}</strong></p>";
        
        echo "<ul style='margin:8px 0; padding-left:20px;'>";
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
        if (isset($result['card_last_digits'])) {
            echo "<li>Cartão terminado em: {$result['card_last_digits']}</li>";
        }
        echo "</ul>";
        
        echo "</div>";
        
        return $result;
    }
    
    // Processa múltiplos pagamentos em sequência
    public static function processMultiplePayments(array $payments) {
        $results = [];
        foreach ($payments as $payment) {
            $results[] = self::executePayment($payment);
        }
        return $results;
    }
}

echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f0f2f5; }
    .container { max-width: 800px; margin: 0 auto; }
</style>";

echo "<div class='container'>";
// Testes com diferentes tipos de pagamento
try {
    $cardPayment = new CardPayment(99.99, '666333333333333', 'George Russel', '06/24', '456');
    $pixPayment = new PixPayment(50.00, 'george.russel@mercedes.com', 'EMAIL');
    $boletoPayment = new BoletoPayment(125.00, date('Y-m-d', strtotime('+5 days')));
    
    echo "<h2>Pagamentos Individuais</h2>";
    PaymentProcessor::executePayment($cardPayment);
    PaymentProcessor::executePayment($pixPayment);
    PaymentProcessor::executePayment($boletoPayment);
    
} catch (InvalidArgumentException $e) {
    echo "<div style='color:red; padding:10px; border:1px solid red; border-radius:5px; margin:10px;'>";
    echo "<strong>Erro:</strong> " . $e->getMessage();
    echo "</div>";
}
echo "</div>";
?>