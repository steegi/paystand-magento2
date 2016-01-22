<?php
namespace PayStand\PayStandMagento\Helper;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\OrderFactory;
use PayStand\PayStandMagento\Model\Directpost;
use PayStand\PayStandMagento\Model\PaymentMethod;
/**
 * PayStand Data Helper
 */
class Data extends AbstractHelper
{
  /**
   * @var \Magento\Store\Model\StoreManagerInterface
   */
  protected $storeManager;
  /**
   * @var \Magento\Sales\Model\OrderFactory
   */
  protected $orderFactory;
  /**
   * Allowed currencies
   *
   * @var array
   */
  protected $allowedCurrencyCodes = ['USD'];

  /**
   * @param \Magento\Framework\App\Helper\Context $context
   * @param \Magento\Store\Model\StoreManagerInterface $storeManager
   * @param \Magento\Sales\Model\OrderFactory $orderFactory
   */
  public function __construct(
    Context $context,
    StoreManagerInterface $storeManager,
    OrderFactory $orderFactory
  ) {
    $this->storeManager = $storeManager;
    $this->orderFactory = $orderFactory;
    parent::__construct($context);
  }
  /**
   * Get payment method step html
   *
   * @param \Magento\Framework\App\ViewInterface $view
   * @return string
   */
  public function getPaymentMethodsHtml(\Magento\Framework\App\ViewInterface $view)
  {
    $layout = $view->getLayout();
    $update = $layout->getUpdate();
    $update->load('checkout_onepage_paymentmethod');
    $layout->generateXml();
    $layout->generateElements();
    $output = $layout->getOutput();
    return $output;
  }
  /**
   * Get allowed currencies
   *
   * @return array
   */
  public function getAllowedCurrencyCodes()
  {
    return $this->allowedCurrencyCodes;
  }
}