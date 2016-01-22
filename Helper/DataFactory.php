<?php
namespace PayStand\PayStandMagento\Helper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;
/**
 * Class DataFactory
 */
class DataFactory
{
  const AREA_FRONTEND = 'frontend';
  /**
   * @var ObjectManagerInterface
   */
  protected $objectManager;
  /**
   * @var array
   */
  protected $helperMap = [
    self::AREA_FRONTEND => 'PayStand\PayStandMagento\Helper\Data',
  ];
  /**
   * Constructor
   *
   * @param ObjectManagerInterface $objectManager
   */
  public function __construct(ObjectManagerInterface $objectManager)
  {
    $this->objectManager = $objectManager;
  }
  /**
   * Create data helper
   *
   * @param string $area
   * @return \PayStand\PayStandMagento\Helper\Backend\Data|\PayStand\PayStandMagento\Helper\Data
   * @throws LocalizedException
   */
  public function create($area)
  {
    if (!isset($this->helperMap[$area])) {
      throw new LocalizedException(__(sprintf('For this area <%s> no suitable helper', $area)));
    }
    return $this->objectManager->get($this->helperMap[$area]);
  }
}