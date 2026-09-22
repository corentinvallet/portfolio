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

/* @Morpheus/layout.twig */
class __TwigTemplate_a32121dcb771ade4a2948e8a3984d0b0 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'head' => [$this, 'block_head'],
            'pageTitle' => [$this, 'block_pageTitle'],
            'pageDescription' => [$this, 'block_pageDescription'],
            'meta' => [$this, 'block_meta'],
            'body' => [$this, 'block_body'],
            'root' => [$this, 'block_root'],
            'pageFooter' => [$this, 'block_pageFooter'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html id=\"ng-app\" ";
        // line 2
        if (array_key_exists("language", $context)) {
            yield "lang=\"";
            yield \Piwik\piwik_escape_filter($this->env, (isset($context["language"]) || array_key_exists("language", $context) ? $context["language"] : (function () { throw new RuntimeError('Variable "language" does not exist.', 2, $this->source); })()), "html", null, true);
            yield "\"";
        }
        yield " data-theme-mode=\"";
        yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, (isset($context["themeStyles"]) || array_key_exists("themeStyles", $context) ? $context["themeStyles"] : (function () { throw new RuntimeError('Variable "themeStyles" does not exist.', 2, $this->source); })()), "getThemeMode", [], "method", false, false, false, 2), "html", null, true);
        yield "\">
    <head>
        ";
        // line 4
        yield from $this->unwrap()->yieldBlock('head', $context, $blocks);
        // line 33
        yield "    </head>
    <body id=\"";
        // line 34
        yield \Piwik\piwik_escape_filter($this->env, ((array_key_exists("bodyId", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["bodyId"]) || array_key_exists("bodyId", $context) ? $context["bodyId"] : (function () { throw new RuntimeError('Variable "bodyId" does not exist.', 34, $this->source); })()), "")) : ("")), "html", null, true);
        yield "\" class=\"";
        yield \Piwik\piwik_escape_filter($this->env, ((array_key_exists("bodyClass", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["bodyClass"]) || array_key_exists("bodyClass", $context) ? $context["bodyClass"] : (function () { throw new RuntimeError('Variable "bodyClass" does not exist.', 34, $this->source); })()), "")) : ("")), "html", null, true);
        yield "\">
        ";
        // line 35
        yield $this->env->getFunction('postEvent')->getCallable()("Template.bodyTop");
        yield "

    ";
        // line 37
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        // line 49
        yield "
        ";
        // line 51
        yield "        ";
        yield from $this->unwrap()->yieldBlock('pageFooter', $context, $blocks);
        // line 56
        yield "
        ";
        // line 57
        yield from         $this->loadTemplate("@CoreHome/_adblockDetect.twig", "@Morpheus/layout.twig", 57)->unwrap()->yield($context);
        // line 58
        yield "
        ";
        // line 59
        yield $this->env->getFunction('postEvent')->getCallable()("Template.bodyBottom");
        yield "
    </body>
</html>
";
        return; yield '';
    }

    // line 4
    public function block_head($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        yield "            <meta charset=\"utf-8\">
            <title>";
        // line 7
        yield from $this->unwrap()->yieldBlock('pageTitle', $context, $blocks);
        // line 12
        yield "</title>
            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=EDGE\"/>
            <meta name=\"viewport\" content=\"initial-scale=1.0\"/>
            <meta name=\"color-scheme\" content=\"light dark\" />
            <meta name=\"generator\" content=\"Matomo - free/libre analytics platform\"/>
            <meta name=\"description\" content=\"";
        // line 17
        yield from $this->unwrap()->yieldBlock('pageDescription', $context, $blocks);
        yield "\"/>
            <meta name=\"apple-itunes-app\" content=\"app-id=737216887\" />
            <meta name=\"google\" content=\"notranslate\">
            ";
        // line 20
        yield from $this->unwrap()->yieldBlock('meta', $context, $blocks);
        // line 23
        yield "
            ";
        // line 24
        yield from         $this->loadTemplate("@CoreHome/_favicon.twig", "@Morpheus/layout.twig", 24)->unwrap()->yield($context);
        // line 25
        yield "            ";
        yield from         $this->loadTemplate("@CoreHome/_applePinnedTabIcon.twig", "@Morpheus/layout.twig", 25)->unwrap()->yield($context);
        // line 26
        yield "            <meta name=\"theme-color\" content=\"";
        yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, (isset($context["themeStyles"]) || array_key_exists("themeStyles", $context) ? $context["themeStyles"] : (function () { throw new RuntimeError('Variable "themeStyles" does not exist.', 26, $this->source); })()), "getPropertyValue", ["colorHeaderBackground"], "method", false, false, false, 26), "html", null, true);
        yield "\">
            ";
        // line 27
        yield from         $this->loadTemplate("_jsGlobalVariables.twig", "@Morpheus/layout.twig", 27)->unwrap()->yield($context);
        // line 28
        yield "            ";
        yield from         $this->loadTemplate("_jsCssIncludes.twig", "@Morpheus/layout.twig", 28)->unwrap()->yield($context);
        // line 30
        if ( !(isset($context["isCustomLogo"]) || array_key_exists("isCustomLogo", $context) ? $context["isCustomLogo"] : (function () { throw new RuntimeError('Variable "isCustomLogo" does not exist.', 30, $this->source); })())) {
            yield "<link rel=\"manifest\" href=\"plugins/CoreHome/javascripts/manifest.json\" crossorigin=\"use-credentials\">";
        }
        // line 31
        yield "
        ";
        return; yield '';
    }

    // line 7
    public function block_pageTitle($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        if (array_key_exists("title", $context)) {
            yield \Piwik\piwik_escape_filter($this->env, (isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 8, $this->source); })()), "html", null, true);
            yield " - ";
        }
        // line 9
        if (array_key_exists("categoryTitle", $context)) {
            yield \Piwik\piwik_escape_filter($this->env, (isset($context["categoryTitle"]) || array_key_exists("categoryTitle", $context) ? $context["categoryTitle"] : (function () { throw new RuntimeError('Variable "categoryTitle" does not exist.', 9, $this->source); })()), "html", null, true);
            yield " - ";
        }
        // line 10
        yield "Matomo";
        return; yield '';
    }

    // line 17
    public function block_pageDescription($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    // line 20
    public function block_meta($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "                <meta name=\"robots\" content=\"noindex,nofollow\">
            ";
        return; yield '';
    }

    // line 37
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 38
        yield "        ";
        yield from         $this->loadTemplate("_iframeBuster.twig", "@Morpheus/layout.twig", 38)->unwrap()->yield($context);
        // line 39
        yield "        ";
        yield from         $this->loadTemplate("@CoreHome/_javaScriptDisabled.twig", "@Morpheus/layout.twig", 39)->unwrap()->yield($context);
        // line 40
        yield "
        <div id=\"root\">
            ";
        // line 42
        yield from $this->unwrap()->yieldBlock('root', $context, $blocks);
        // line 44
        yield "        </div>

        ";
        // line 46
        yield from         $this->loadTemplate("@CoreHome/_shortcuts.twig", "@Morpheus/layout.twig", 46)->unwrap()->yield($context);
        // line 47
        yield "
    ";
        return; yield '';
    }

    // line 42
    public function block_root($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "            ";
        return; yield '';
    }

    // line 51
    public function block_pageFooter($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 52
        yield "            <div id=\"pageFooter\">
                ";
        // line 53
        yield $this->env->getFunction('postEvent')->getCallable()("Template.pageFooter");
        yield "
            </div>
        ";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@Morpheus/layout.twig";
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
        return array (  230 => 53,  227 => 52,  223 => 51,  215 => 42,  209 => 47,  207 => 46,  203 => 44,  201 => 42,  197 => 40,  194 => 39,  191 => 38,  187 => 37,  178 => 20,  171 => 17,  166 => 10,  161 => 9,  156 => 8,  152 => 7,  146 => 31,  142 => 30,  139 => 28,  137 => 27,  132 => 26,  129 => 25,  127 => 24,  124 => 23,  122 => 20,  116 => 17,  109 => 12,  107 => 7,  104 => 5,  100 => 4,  91 => 59,  88 => 58,  86 => 57,  83 => 56,  80 => 51,  77 => 49,  75 => 37,  70 => 35,  64 => 34,  61 => 33,  59 => 4,  48 => 2,  45 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html id=\"ng-app\" {% if language is defined %}lang=\"{{ language }}\"{% endif %} data-theme-mode=\"{{ themeStyles.getThemeMode() }}\">
    <head>
        {% block head %}
            <meta charset=\"utf-8\">
            <title>
                {%- block pageTitle %}
                    {%- if title is defined -%}{{ title }} - {% endif -%}
                    {%- if categoryTitle is defined -%}{{ categoryTitle }} - {% endif -%}
                    Matomo
                {%- endblock -%}
            </title>
            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=EDGE\"/>
            <meta name=\"viewport\" content=\"initial-scale=1.0\"/>
            <meta name=\"color-scheme\" content=\"light dark\" />
            <meta name=\"generator\" content=\"Matomo - free/libre analytics platform\"/>
            <meta name=\"description\" content=\"{% block pageDescription %}{% endblock %}\"/>
            <meta name=\"apple-itunes-app\" content=\"app-id=737216887\" />
            <meta name=\"google\" content=\"notranslate\">
            {% block meta %}
                <meta name=\"robots\" content=\"noindex,nofollow\">
            {% endblock %}

            {% include \"@CoreHome/_favicon.twig\" %}
            {% include \"@CoreHome/_applePinnedTabIcon.twig\" %}
            <meta name=\"theme-color\" content=\"{{ themeStyles.getPropertyValue('colorHeaderBackground') }}\">
            {% include \"_jsGlobalVariables.twig\" %}
            {% include \"_jsCssIncludes.twig\" %}

            {%- if not isCustomLogo %}<link rel=\"manifest\" href=\"plugins/CoreHome/javascripts/manifest.json\" crossorigin=\"use-credentials\">{% endif %}

        {% endblock %}
    </head>
    <body id=\"{{ bodyId|default('') }}\" class=\"{{ bodyClass|default('') }}\">
        {{ postEvent('Template.bodyTop' ) }}

    {% block body %}
        {% include \"_iframeBuster.twig\" %}
        {% include \"@CoreHome/_javaScriptDisabled.twig\" %}

        <div id=\"root\">
            {% block root %}
            {% endblock %}
        </div>

        {% include \"@CoreHome/_shortcuts.twig\" %}

    {% endblock %}

        {# Overridable so a layout can render the footer links elsewhere without posting twice. #}
        {% block pageFooter %}
            <div id=\"pageFooter\">
                {{ postEvent('Template.pageFooter') }}
            </div>
        {% endblock %}

        {% include \"@CoreHome/_adblockDetect.twig\" %}

        {{ postEvent('Template.bodyBottom' ) }}
    </body>
</html>
", "@Morpheus/layout.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Morpheus/templates/layout.twig");
    }
}
