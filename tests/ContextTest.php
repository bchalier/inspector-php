<?php


namespace LogEngine\Tests;


use LogEngine\ApmAgent;
use LogEngine\Configuration;
use PHPUnit\Framework\TestCase;

class ContextTest extends TestCase
{
    /**
     * @var ApmAgent
     */
    protected $apm;

    /**
     * @throws \LogEngine\Exceptions\LogEngineApmException
     */
    public function setUp()
    {
        $config = new Configuration('example-key');
        $config->setEnabled(false);

        $this->apm = new ApmAgent($config);
        $this->apm->startTransaction('testcase');
    }

    /**
     * @throws \Exception
     */
    public function testTransactionContextEmpty()
    {
        $this->assertSame(json_encode([]), json_encode($this->apm->currentTransaction()->getContext()));
    }

    /**
     * @throws \Exception
     */
    public function testSpanContextEmpty()
    {
        $span = $this->apm->startSpan('testSpanContextEmpty');

        $this->assertSame(json_encode([]), json_encode($span->getContext()));
    }

    /**
     * @throws \Exception
     */
    public function testErrorContextEmpty()
    {
        $error = $this->apm->reportException(new \Exception('testSpanContextEmpty'));

        $this->assertSame(json_encode([]), json_encode($error->getContext()));
    }
}