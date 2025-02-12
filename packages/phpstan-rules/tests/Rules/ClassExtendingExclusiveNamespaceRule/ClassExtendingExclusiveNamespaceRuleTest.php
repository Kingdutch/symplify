<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule;

use Iterator;
use Nette\Utils\Json;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use ReflectionClass;
use Symplify\PHPStanRules\Rules\ClassExtendingExclusiveNamespaceRule;
use Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\CommandInUnauthorizedNamespace;
use Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Component\PriceProviderInUnauthorizedNamespace;
use Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\ExceptionInUnauthorizedNamespace;
use Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\FormInUnauthorizedNamespace;
use Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Model\Customer\CustomerRequestModelInUnauthorizedNamespace;
use Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Model\Order\OrderRequestModelInUnauthorizedNamespace;

/**
 * @extends RuleTestCase<ClassExtendingExclusiveNamespaceRule>
 */
final class ClassExtendingExclusiveNamespaceRuleTest extends RuleTestCase
{
    /**
     * @dataProvider provideData()
     * @param mixed[] $expectedErrorMessagesWithLines
     */
    public function testRule(string $filePath, array $expectedErrorMessagesWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorMessagesWithLines);
    }

    /**
     * @return Iterator<mixed>
     */
    public function provideData(): Iterator
    {
        yield [__DIR__ . '/Fixture/App/Command/SkipCommandInAuthorizedNamespace.php', []];
        yield [__DIR__ . '/Fixture/App/Form/SkipFormInAuthorizedNamespace.php', []];
        yield [__DIR__ . '/Fixture/App/Model/Customer/Request/SkipCustomerRequestModelInAuthorizedNamespace.php', []];
        yield [__DIR__ . '/Fixture/App/Model/Order/Request/SkipOrderRequestModelInAuthorizedNamespace.php', []];
        yield [__DIR__ . '/Fixture/App/Exception/SkipExceptionInAuthorizedNamespace.php', []];
        yield [__DIR__ . '/Fixture/App/Services/SkipExceptionInAuthorizedNamespace.php', []];
        yield [__DIR__ . '/Fixture/App/Component/PriceEngine/SkipFallbackPriceProviderInAuthorizedNamespace.php', []];
        yield [
            __DIR__ . '/Fixture/App/Component/PriceEngineImpl/SkipCustomerPriceProviderInAuthorizedNamespace.php',
            [],
        ];
        yield [
            __DIR__ . '/Fixture/App/Component/PriceEngineImpl/SkipCustomerProductProviderInAuthorizedNamespace.php',
            [],
        ];
        yield [
            __DIR__ . '/Fixture/App/Component/PriceEngineImpl/SkipDealerPriceProviderInAuthorizedNamespace.php',
            [],
        ];
        yield [
            __DIR__ . '/Fixture/App/Component/PriceEngineImpl/SkipDealerProductProviderInAuthorizedNamespace.php',
            [],
        ];

        yield [
            __DIR__ . '/Fixture/App/CommandInUnauthorizedNamespace.php',
            [
                [
                    sprintf(
                        ClassExtendingExclusiveNamespaceRule::ERROR_MESSAGE,
                        CommandInUnauthorizedNamespace::class,
                        Json::encode(
                            [
                                'Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Command\**',
                            ]
                        ),
                        (new ReflectionClass(CommandInUnauthorizedNamespace::class))->getNamespaceName(),
                    ),
                    9,
                ],
            ],
        ];

        yield [
            __DIR__ . '/Fixture/App/FormInUnauthorizedNamespace.php',
            [
                [
                    sprintf(
                        ClassExtendingExclusiveNamespaceRule::ERROR_MESSAGE,
                        FormInUnauthorizedNamespace::class,
                        Json::encode(
                            [
                                'Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Form\**', ]
                        ),
                        (new ReflectionClass(FormInUnauthorizedNamespace::class))->getNamespaceName(),
                    ),
                    7,
                ],
            ],
        ];

        yield [
            __DIR__ . '/Fixture/App/Model/Customer/CustomerRequestModelInUnauthorizedNamespace.php',
            [
                [
                    sprintf(
                        ClassExtendingExclusiveNamespaceRule::ERROR_MESSAGE,
                        CustomerRequestModelInUnauthorizedNamespace::class,
                        Json::encode(
                            [
                                'Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Model\**\Request\**', ]
                        ),
                        (new ReflectionClass(CustomerRequestModelInUnauthorizedNamespace::class))->getNamespaceName(),
                    ),
                    7,
                ],
            ],
        ];

        yield [
            __DIR__ . '/Fixture/App/Model/Order/OrderRequestModelInUnauthorizedNamespace.php',
            [
                [
                    sprintf(
                        ClassExtendingExclusiveNamespaceRule::ERROR_MESSAGE,
                        OrderRequestModelInUnauthorizedNamespace::class,
                        Json::encode(
                            [
                                'Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Model\**\Request\**', ]
                        ),
                        (new ReflectionClass(OrderRequestModelInUnauthorizedNamespace::class))->getNamespaceName(),
                    ),
                    7,
                ],
            ],
        ];

        yield [
            __DIR__ . '/Fixture/App/ExceptionInUnauthorizedNamespace.php',
            [
                [
                    sprintf(
                        ClassExtendingExclusiveNamespaceRule::ERROR_MESSAGE,
                        ExceptionInUnauthorizedNamespace::class,
                        Json::encode([
                            'Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Exception\**',
                            'Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Services\**',
                        ]),
                        (new ReflectionClass(ExceptionInUnauthorizedNamespace::class))->getNamespaceName(),
                    ),
                    9,
                ],
            ],
        ];

        yield [
            __DIR__ . '/Fixture/App/Component/PriceProviderInUnauthorizedNamespace.php',
            [
                [
                    sprintf(
                        ClassExtendingExclusiveNamespaceRule::ERROR_MESSAGE,
                        PriceProviderInUnauthorizedNamespace::class,
                        Json::encode([
                            'Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Component\PriceEngine\**',
                            'Symplify\PHPStanRules\Tests\Rules\ClassExtendingExclusiveNamespaceRule\Fixture\App\Component\PriceEngineImpl\**',
                        ]),
                        (new ReflectionClass(PriceProviderInUnauthorizedNamespace::class))->getNamespaceName(),
                    ),
                    7,
                ],
            ],
        ];
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ClassExtendingExclusiveNamespaceRule::class);
    }
}
