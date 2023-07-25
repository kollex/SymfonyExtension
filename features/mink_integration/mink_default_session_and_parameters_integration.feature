<<<<<<<< HEAD:features/mink_integration/mink_default_session_and_parameters_integration.feature
Feature: Mink default session and parameters integration
========
Feature: Mink integration
>>>>>>>> 9e9529c (Add tests for context initializers):features/mink_integration/mink_integration.feature

    Background:
        Given a working Symfony application with SymfonyExtension configured
        And a Behat configuration containing:
        """
        default:
            extensions:
                Behat\MinkExtension:
                    base_url: "http://localhost:8080/"
                    default_session: symfony
                    sessions:
                        symfony:
                            symfony: ~
            suites:
                default:
                    contexts:
                        - App\Tests\SomeContext
        """
        And a feature file containing:
        """
        Feature:
            Scenario:
                When I visit the page "/hello-world"
                Then I should see "Hello world!" on the page
                And the base url from Mink parameters should be "http://localhost:8080/"

            # Doubling the scenario to account for some weird error connected to Mink's session
            Scenario:
                When I visit the page "/hello-world"
                Then I should see "Hello world!" on the page
                And the base url from Mink parameters should be "http://localhost:8080/"
        """
        And a context file "tests/SomeContext.php" containing:
        """
        <?php

        namespace App\Tests;

        use Behat\Behat\Context\Context;
        use Behat\Mink\Session;
        use FriendsOfBehat\SymfonyExtension\Mink\MinkParameters;
        use Psr\Container\ContainerInterface;

        final class SomeContext implements Context {
            private $session;
            private $parameters;

            public function __construct(Session $session, MinkParameters $minkParameters)
            {
                $this->session = $session;
                $this->parameters = $minkParameters;
            }

            /** @When I visit the page :page */
            public function visitPage(string $page): void
            {
                $this->session->visit($page);
            }

            /** @Then I should see :content on the page */
            public function shouldSeeContentOnPage(string $content): void
            {
                assert(false !== strpos($this->session->getPage()->getContent(), $content));
            }

            /** @Then the base url from Mink parameters should be :expected */
            public function baseUrlShouldBe(string $expected): void
            {
                assert(isset($this->parameters['base_url']));
                assert($this->parameters['base_url'] === $expected);
            }
        }
        """

    Scenario: Injecting Mink session and Mink parameters
        Given a YAML services file containing:
            """
            services:
                App\Tests\SomeContext:
                    public: true
                    arguments:
                        - '@behat.mink.default_session'
                        - '@behat.mink.parameters'
            """
        When I run Behat
        Then it should pass

    Scenario: Autowiring and autoconfiguring Mink session and Mink parameters
        Given a YAML services file containing:
            """
            services:
                _defaults:
                    autowire: true
                    autoconfigure: true

                App\Tests\SomeContext: ~
            """
        When I run Behat
        Then it should pass
