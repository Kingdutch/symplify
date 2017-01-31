<?php declare(strict_types=1);

namespace Symplify\PHP7_CodeSniffer\Sniff\Factory;

use PHP_CodeSniffer\Sniffs\Sniff;
use Symplify\PHP7_CodeSniffer\Contract\Sniff\Factory\SniffFactoryInterface;
use Symplify\PHP7_CodeSniffer\Sniff\Routing\Router;

final class SniffCodeToSniffsFactory implements SniffFactoryInterface
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var SingleSniffFactory
     */
    private $singleSniffFactory;

    public function __construct(Router $router, SingleSniffFactory $singleSniffFactory)
    {
        $this->router = $router;
        $this->singleSniffFactory = $singleSniffFactory;
    }

    public function isMatch(string $reference) : bool
    {
        $partsCount = count(explode('.', $reference));
        return $partsCount === 3;
    }

    /**
     * @return Sniff[]
     */
    public function create(string $sniffCode) : array
    {
        $sniffClassName = $this->router->getClassFromSniffCode($sniffCode);
        $sniff = $this->singleSniffFactory->create($sniffClassName);
        if ($sniff !== null) {
            return [$sniff];
        }

        return [];
    }
}
