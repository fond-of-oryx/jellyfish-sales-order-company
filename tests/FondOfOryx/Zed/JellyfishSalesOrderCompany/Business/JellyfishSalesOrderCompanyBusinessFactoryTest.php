<?php

namespace FondOfOryx\Zed\JellyfishSalesOrderCompany\Business;

use Codeception\Test\Unit;
use FondOfOryx\Zed\JellyfishSalesOrderCompany\Business\Expander\JellyfishOrderExpander;
use FondOfOryx\Zed\JellyfishSalesOrderCompany\Dependency\Facade\JellyfishSalesOrderCompanyToCompanyUserReferenceFacadeInterface;
use FondOfOryx\Zed\JellyfishSalesOrderCompany\Dependency\Facade\JellyfishSalesOrderCompanyToCurrencyFacadeInterface;
use FondOfOryx\Zed\JellyfishSalesOrderCompany\Dependency\Facade\JellyfishSalesOrderCompanyToLocaleFacadeInterface;
use FondOfOryx\Zed\JellyfishSalesOrderCompany\JellyfishSalesOrderCompanyDependencyProvider;
use Spryker\Zed\Kernel\Container;

class JellyfishSalesOrderCompanyBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \FondOfOryx\Zed\JellyfishSalesOrderCompany\Dependency\Facade\JellyfishSalesOrderCompanyToCompanyUserReferenceFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReferenceFacadeMock;

    /**
     * @var \FondOfOryx\Zed\JellyfishSalesOrderCompany\Dependency\Facade\JellyfishSalesOrderCompanyToLocaleFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $localeFacadeMock;

    /**
     * @var \FondOfOryx\Zed\JellyfishSalesOrderCompany\Dependency\Facade\JellyfishSalesOrderCompanyToCurrencyFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $currencyFacadeMock;

    /**
     * @var \FondOfOryx\Zed\JellyfishSalesOrderCompany\Business\JellyfishSalesOrderCompanyBusinessFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFacadeMock = $this->getMockBuilder(JellyfishSalesOrderCompanyToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeFacadeMock = $this->getMockBuilder(JellyfishSalesOrderCompanyToLocaleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyFacadeMock = $this->getMockBuilder(JellyfishSalesOrderCompanyToCurrencyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new JellyfishSalesOrderCompanyBusinessFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateJellyfishOrderExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [JellyfishSalesOrderCompanyDependencyProvider::FACADE_LOCALE],
                [JellyfishSalesOrderCompanyDependencyProvider::FACADE_CURRENCY],
                [JellyfishSalesOrderCompanyDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
            )->willReturnOnConsecutiveCalls(
                $this->localeFacadeMock,
                $this->currencyFacadeMock,
                $this->companyUserReferenceFacadeMock,
            );

        static::assertInstanceOf(
            JellyfishOrderExpander::class,
            $this->factory->createJellyfishOrderExpander(),
        );
    }
}
