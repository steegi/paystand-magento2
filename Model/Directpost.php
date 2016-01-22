<?php

namespace PayStand\PayStandMagento\Model;

use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Sales\Model\Order\Email\Sender\OrderSender;

/**
 * PayStand DirectPost payment method model.
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Directpost extends \PayStand\PayStandMagento\Model\PaymentMethod
{
    const METHOD_CODE = 'paystandmagento_directpost';

    /**
    * Payment Method feature
    *
    * @var bool
    */
    protected $_isGateway = true;

    /**
    * Payment Method feature
    *
    * @var bool
    */
    protected $_canAuthorize = false;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var OrderSender
     */
    protected $orderSender;

    /**
     * Order factory
     *
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;

    /**
     * @var \Magento\Sales\Api\TransactionRepositoryInterface
     */
    protected $transactionRepository;

    /**
     * @var \Magento\Payment\Model\Method\Logger
     */
    protected $logger;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Magento\Payment\Helper\Data $paymentData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Payment\Model\Method\Logger $logger
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \PayStand\PayStandMagento\Helper\Data $dataHelper
     * @param \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param OrderSender $orderSender
     * @param \Magento\Sales\Api\TransactionRepositoryInterface $transactionRepository
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \PayStand\PayStandMagento\Helper\Data $dataHelper,
        ZendClientFactory $httpClientFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender,
        \Magento\Sales\Api\TransactionRepositoryInterface $transactionRepository,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->orderFactory = $orderFactory;
        $this->storeManager = $storeManager;
        $this->quoteRepository = $quoteRepository;
        $this->orderSender = $orderSender;
        $this->transactionRepository = $transactionRepository;
        $this->logger = $logger;
        $this->_code = static::METHOD_CODE;

        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $moduleList,
            $localeDate,
            $dataHelper,
            $httpClientFactory,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
    * Set data helper
    *
    * @param \PayStand\PayStandMagento\Helper\Data $dataHelper
    * @return void
    */
    public function setDataHelper(\PayStand\PayStandMagento\Helper\Data $dataHelper)
    {
        $this->dataHelper = $dataHelper;
    }

    /**
    * Send authorize request to gateway
    *
    * @param \Magento\Framework\DataObject|\Magento\Payment\Model\InfoInterface $payment
    * @param  float $amount
    * @return void
    * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    */
    public function authorize(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        $this->_logger->addDebug('Directpost authorize was hit');
        $payment->setAdditionalInformation('is_transaction_pending', 1);
        $order = $payment->getOrder();
        $order->setState('pending');
        $order->setStatus('pending');
    }

    /**
     * Do not validate payment form using server methods
     *
     * @return bool
     */
    public function validate()
    {
        return true;
    }

    /**
     * {inheritdoc}
     */
    public function getConfigInterface()
    {
        return $this;
    }


}
