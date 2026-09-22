<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @Login/loginLayout.twig */
class __TwigTemplate_b8ac5933c679bc15eb14920173a68e93 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'meta' => [$this, 'block_meta'],
            'head' => [$this, 'block_head'],
            'pageDescription' => [$this, 'block_pageDescription'],
            'body' => [$this, 'block_body'],
            'loginContent' => [$this, 'block_loginContent'],
            'pageFooter' => [$this, 'block_pageFooter'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@Morpheus/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 12
        $context["title"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            yield \Piwik\piwik_escape_filter($this->env, ((array_key_exists("pageTitle", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["pageTitle"]) || array_key_exists("pageTitle", $context) ? $context["pageTitle"] : (function () { throw new RuntimeError('Variable "pageTitle" does not exist.', 12, $this->source); })()), $this->env->getFilter('translate')->getCallable()("Login_LogIn"))) : ($this->env->getFilter('translate')->getCallable()("Login_LogIn"))), "html", null, true);
            return; yield '';
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 16
        $context["bodyId"] = "loginPage";
        // line 19
        $context["bodyClass"] = Twig\Extension\CoreExtension::trim(("app-loginLayout " . ((array_key_exists("bodyClass", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["bodyClass"]) || array_key_exists("bodyClass", $context) ? $context["bodyClass"] : (function () { throw new RuntimeError('Variable "bodyClass" does not exist.', 19, $this->source); })()), "")) : (""))));
        // line 1
        $this->parent = $this->loadTemplate("@Morpheus/layout.twig", "@Login/loginLayout.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_meta($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "    <meta name=\"robots\" content=\"noindex,nofollow\">
";
        return; yield '';
    }

    // line 7
    public function block_head($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        yield "    ";
        $context["deferjs"] = true;
        // line 9
        yield "    ";
        yield from $this->yieldParentBlock("head", $context, $blocks);
        yield "
";
        return; yield '';
    }

    // line 14
    public function block_pageDescription($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_OpenSourceWebAnalytics"), "html", null, true);
        return; yield '';
    }

    // line 21
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 22
        yield "
    ";
        // line 23
        yield $this->env->getFunction('postEvent')->getCallable()("Template.beforeTopBar", "login");
        yield "
    ";
        // line 24
        yield $this->env->getFunction('postEvent')->getCallable()("Template.beforeContent", "login");
        yield "

    ";
        // line 26
        yield from         $this->loadTemplate("_iframeBuster.twig", "@Login/loginLayout.twig", 26)->unwrap()->yield($context);
        // line 27
        yield "
    <div id=\"notificationContainer\">
    </div>

    <div class=\"loginLayout\">
        <div class=\"loginLayout__primary\">
            <div class=\"loginLayout__logo\">
                ";
        // line 34
        yield from         $this->loadTemplate("@CoreHome/_logo.twig", "@Login/loginLayout.twig", 34)->unwrap()->yield(CoreExtension::merge($context, ["logoLink" => "https://matomo.org", "centeredLogo" => false, "useLargeLogo" => false]));
        // line 35
        yield "            </div>

            <div class=\"loginLayout__content loginSection\">
                ";
        // line 39
        yield "                ";
        if (((array_key_exists("isValidHost", $context) && array_key_exists("invalidHostMessage", $context)) && ((isset($context["isValidHost"]) || array_key_exists("isValidHost", $context) ? $context["isValidHost"] : (function () { throw new RuntimeError('Variable "isValidHost" does not exist.', 39, $this->source); })()) == false))) {
            // line 40
            yield "                    ";
            yield from             $this->loadTemplate("@CoreHome/_warningInvalidHost.twig", "@Login/loginLayout.twig", 40)->unwrap()->yield($context);
            // line 41
            yield "                ";
        } else {
            // line 42
            yield "                    ";
            yield from $this->unwrap()->yieldBlock('loginContent', $context, $blocks);
            // line 44
            yield "                ";
        }
        // line 45
        yield "            </div>

            ";
        // line 49
        yield "            ";
        $context["footerLinks"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            yield $this->env->getFunction('postEvent')->getCallable()("Template.pageFooter");
            return; yield '';
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 50
        yield "
            ";
        // line 51
        if ( !Twig\Extension\CoreExtension::testEmpty(Twig\Extension\CoreExtension::trim((isset($context["footerLinks"]) || array_key_exists("footerLinks", $context) ? $context["footerLinks"] : (function () { throw new RuntimeError('Variable "footerLinks" does not exist.', 51, $this->source); })())))) {
            // line 52
            yield "                <div class=\"loginLayout__footerLinks\">";
            yield \Piwik\piwik_escape_filter($this->env, (isset($context["footerLinks"]) || array_key_exists("footerLinks", $context) ? $context["footerLinks"] : (function () { throw new RuntimeError('Variable "footerLinks" does not exist.', 52, $this->source); })()), "html", null, true);
            yield "</div>
            ";
        }
        // line 54
        yield "        </div>

        ";
        // line 57
        yield "        ";
        if ((array_key_exists("whatsNewChanges", $context) &&  !Twig\Extension\CoreExtension::testEmpty((isset($context["whatsNewChanges"]) || array_key_exists("whatsNewChanges", $context) ? $context["whatsNewChanges"] : (function () { throw new RuntimeError('Variable "whatsNewChanges" does not exist.', 57, $this->source); })())))) {
            // line 58
            yield "            <div class=\"loginLayout__secondary\">
                ";
            // line 59
            yield from             $this->loadTemplate("@Login/_whatsNewPanel.twig", "@Login/loginLayout.twig", 59)->unwrap()->yield(CoreExtension::merge($context, ["changes" => (isset($context["whatsNewChanges"]) || array_key_exists("whatsNewChanges", $context) ? $context["whatsNewChanges"] : (function () { throw new RuntimeError('Variable "whatsNewChanges" does not exist.', 59, $this->source); })())]));
            // line 60
            yield "            </div>
        ";
        }
        // line 62
        yield "    </div>

";
        return; yield '';
    }

    // line 42
    public function block_loginContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "                    ";
        return; yield '';
    }

    // line 67
    public function block_pageFooter($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@Login/loginLayout.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  195 => 67,  187 => 42,  180 => 62,  176 => 60,  174 => 59,  171 => 58,  168 => 57,  164 => 54,  158 => 52,  156 => 51,  153 => 50,  147 => 49,  143 => 45,  140 => 44,  137 => 42,  134 => 41,  131 => 40,  128 => 39,  123 => 35,  121 => 34,  112 => 27,  110 => 26,  105 => 24,  101 => 23,  98 => 22,  94 => 21,  86 => 14,  78 => 9,  75 => 8,  71 => 7,  62 => 3,  57 => 1,  55 => 19,  53 => 16,  48 => 12,  41 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends '@Morpheus/layout.twig' %}

{% block meta %}
    <meta name=\"robots\" content=\"noindex,nofollow\">
{% endblock %}

{% block head %}
    {% set deferjs = true %}
    {{ parent() }}
{% endblock %}

{% set title %}{{ pageTitle|default('Login_LogIn'|translate) }}{% endset %}

{% block pageDescription %}{{ 'General_OpenSourceWebAnalytics'|translate }}{% endblock %}

{% set bodyId = 'loginPage' %}
{# Appended rather than assigned: this runs after the extending template's own sets, so a
   plain assignment would silently drop a body class the child asked for. #}
{% set bodyClass = ('app-loginLayout ' ~ bodyClass|default(''))|trim %}

{% block body %}

    {{ postEvent(\"Template.beforeTopBar\", \"login\") }}
    {{ postEvent(\"Template.beforeContent\", \"login\") }}

    {% include \"_iframeBuster.twig\" %}

    <div id=\"notificationContainer\">
    </div>

    <div class=\"loginLayout\">
        <div class=\"loginLayout__primary\">
            <div class=\"loginLayout__logo\">
                {% include \"@CoreHome/_logo.twig\" with { 'logoLink': 'https://matomo.org', 'centeredLogo': false, 'useLargeLogo': false } %}
            </div>

            <div class=\"loginLayout__content loginSection\">
                {# untrusted host warning #}
                {% if (isValidHost is defined and invalidHostMessage is defined and isValidHost == false) %}
                    {% include '@CoreHome/_warningInvalidHost.twig' %}
                {% else %}
                    {% block loginContent %}
                    {% endblock %}
                {% endif %}
            </div>

            {# The shared page footer sits outside this layout, so render its links under the form.
               The parent's footer block is emptied below, so the event is still posted only once. #}
            {% set footerLinks %}{{ postEvent('Template.pageFooter') }}{% endset %}

            {% if footerLinks|trim is not empty %}
                <div class=\"loginLayout__footerLinks\">{{ footerLinks }}</div>
            {% endif %}
        </div>

        {# The secondary column is dropped entirely when there is nothing to show in it. #}
        {% if whatsNewChanges is defined and whatsNewChanges is not empty %}
            <div class=\"loginLayout__secondary\">
                {% include '@Login/_whatsNewPanel.twig' with { 'changes': whatsNewChanges } %}
            </div>
        {% endif %}
    </div>

{% endblock %}

{# Emptied because the layout above already renders the footer links. #}
{% block pageFooter %}{% endblock %}
", "@Login/loginLayout.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Login/templates/loginLayout.twig");
    }
}
