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

/* dashboard.twig */
class __TwigTemplate_929950db8eab8f2238a05efd653d94ec extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'head' => [$this, 'block_head'],
            'pageDescription' => [$this, 'block_pageDescription'],
            'body' => [$this, 'block_body'],
            'root' => [$this, 'block_root'],
            'topcontrols' => [$this, 'block_topcontrols'],
            'notification' => [$this, 'block_notification'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        $context["title"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            yield (isset($context["siteName"]) || array_key_exists("siteName", $context) ? $context["siteName"] : (function () { throw new RuntimeError('Variable "siteName" does not exist.', 7, $this->source); })());
            yield " - ";
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("CoreHome_WebAnalyticsReports"), "html", null, true);
            return; yield '';
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 11
        $context["bodyClass"] = $this->env->getFunction('postEvent')->getCallable()("Template.bodyClass", "dashboard");
        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "dashboard.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        yield "    ";
        yield from $this->yieldParentBlock("head", $context, $blocks);
        yield "
";
        return; yield '';
    }

    // line 9
    public function block_pageDescription($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Web Analytics report for ";
        yield \Piwik\piwik_escape_filter($this->env, (isset($context["siteName"]) || array_key_exists("siteName", $context) ? $context["siteName"] : (function () { throw new RuntimeError('Variable "siteName" does not exist.', 9, $this->source); })()), "html_attr");
        yield " - Matomo";
        return; yield '';
    }

    // line 13
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 14
        yield "    ";
        yield $this->env->getFunction('postEvent')->getCallable()("Template.header", "dashboard");
        yield "
    ";
        // line 15
        yield from $this->yieldParentBlock("body", $context, $blocks);
        yield "
    ";
        // line 16
        yield $this->env->getFunction('postEvent')->getCallable()("Template.footer", "dashboard");
        yield "
";
        return; yield '';
    }

    // line 19
    public function block_root($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 20
        yield "    ";
        yield from         $this->loadTemplate("@CoreHome/_warningInvalidHost.twig", "dashboard.twig", 20)->unwrap()->yield($context);
        // line 21
        yield "    ";
        yield from         $this->loadTemplate("@CoreHome/_topScreen.twig", "dashboard.twig", 21)->unwrap()->yield($context);
        // line 22
        yield "
    ";
        // line 23
        $context["hasSidebar"] = (array_key_exists("showMenu", $context) && (isset($context["showMenu"]) || array_key_exists("showMenu", $context) ? $context["showMenu"] : (function () { throw new RuntimeError('Variable "showMenu" does not exist.', 23, $this->source); })()));
        // line 24
        yield "
    <div class=\"layoutWithSidebar";
        // line 25
        if ((isset($context["hasSidebar"]) || array_key_exists("hasSidebar", $context) ? $context["hasSidebar"] : (function () { throw new RuntimeError('Variable "hasSidebar" does not exist.', 25, $this->source); })())) {
            yield " layoutWithSidebar--hasSidebar";
        }
        yield "\">
        ";
        // line 26
        if ((isset($context["hasSidebar"]) || array_key_exists("hasSidebar", $context) ? $context["hasSidebar"] : (function () { throw new RuntimeError('Variable "hasSidebar" does not exist.', 26, $this->source); })())) {
            // line 27
            yield "            <div id=\"secondNavBar\" class=\"sideBar Menu--dashboard z-depth-1\">
                <div vue-entry=\"CoreHome.QuickAccess\"></div>
                <div vue-entry=\"CoreHome.ReportingMenu\"></div>
            </div>
        ";
        }
        // line 32
        yield "        <div class=\"layoutWithSidebarContent\">
            <div class=\"top_controls\">
                ";
        // line 34
        yield from $this->unwrap()->yieldBlock('topcontrols', $context, $blocks);
        // line 36
        yield "            </div>

            <div class=\"page\">
                <div class=\"pageWrap\">
                    <div class=\"ui-confirm\" id=\"alert\">
                        <h2></h2>
                        <input role=\"yes\" type=\"button\" value=\"";
        // line 42
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Ok"), "html", null, true);
        yield "\"/>
                    </div>

                    ";
        // line 45
        yield $this->env->getFunction('postEvent')->getCallable()("Template.beforeContent", "dashboard", (isset($context["currentModule"]) || array_key_exists("currentModule", $context) ? $context["currentModule"] : (function () { throw new RuntimeError('Variable "currentModule" does not exist.', 45, $this->source); })()), (isset($context["currentAction"]) || array_key_exists("currentAction", $context) ? $context["currentAction"] : (function () { throw new RuntimeError('Variable "currentAction" does not exist.', 45, $this->source); })()));
        yield "

                    <a name=\"main\"></a>
                    ";
        // line 48
        yield from $this->unwrap()->yieldBlock('notification', $context, $blocks);
        // line 51
        yield "
                    <div vue-entry=\"CoreHome.Comparisons\"></div>

                    ";
        // line 54
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 56
        yield "
                    <div class=\"clear\"></div>
                </div>
            </div>
        </div>
    </div>

";
        // line 63
        if ((array_key_exists("whatisnewShow", $context) && (isset($context["whatisnewShow"]) || array_key_exists("whatisnewShow", $context) ? $context["whatisnewShow"] : (function () { throw new RuntimeError('Variable "whatisnewShow" does not exist.', 63, $this->source); })()))) {
            // line 64
            yield "    <script>
        document.addEventListener(\"DOMContentLoaded\", function(event) {
            const tooltip = '";
            // line 66
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("CoreAdminHome_WhatIsNewTooltip"), "html", null, true);
            yield "';
            window.Piwik_Popover.createPopupAndLoadUrl('module=CoreAdminHome&action=whatIsNew', tooltip.replace(/&#039;/g,\"'\"), 'what-is-new-popup');
        });
    </script>
";
        }
        // line 71
        yield "
";
        return; yield '';
    }

    // line 34
    public function block_topcontrols($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "                ";
        return; yield '';
    }

    // line 48
    public function block_notification($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 49
        yield "                        ";
        yield from         $this->loadTemplate("@CoreHome/_notifications.twig", "dashboard.twig", 49)->unwrap()->yield($context);
        // line 50
        yield "                    ";
        return; yield '';
    }

    // line 54
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "                    ";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "dashboard.twig";
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
        return array (  222 => 54,  217 => 50,  214 => 49,  210 => 48,  202 => 34,  196 => 71,  188 => 66,  184 => 64,  182 => 63,  173 => 56,  171 => 54,  166 => 51,  164 => 48,  158 => 45,  152 => 42,  144 => 36,  142 => 34,  138 => 32,  131 => 27,  129 => 26,  123 => 25,  120 => 24,  118 => 23,  115 => 22,  112 => 21,  109 => 20,  105 => 19,  98 => 16,  94 => 15,  89 => 14,  85 => 13,  75 => 9,  67 => 4,  63 => 3,  58 => 1,  56 => 11,  49 => 7,  42 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'layout.twig' %}

{% block head %}
    {{ parent() }}
{% endblock %}

{% set title %}{{ siteName|raw }} - {{ 'CoreHome_WebAnalyticsReports'|translate }}{% endset %}

{% block pageDescription %}Web Analytics report for {{ siteName|escape(\"html_attr\") }} - Matomo{% endblock %}

{% set bodyClass = postEvent('Template.bodyClass', 'dashboard') %}

{% block body %}
    {{ postEvent(\"Template.header\", \"dashboard\") }}
    {{ parent() }}
    {{ postEvent(\"Template.footer\", \"dashboard\") }}
{% endblock %}

{% block root %}
    {% include \"@CoreHome/_warningInvalidHost.twig\" %}
    {% include \"@CoreHome/_topScreen.twig\" %}

    {% set hasSidebar = showMenu is defined and showMenu %}

    <div class=\"layoutWithSidebar{% if hasSidebar %} layoutWithSidebar--hasSidebar{% endif %}\">
        {% if hasSidebar %}
            <div id=\"secondNavBar\" class=\"sideBar Menu--dashboard z-depth-1\">
                <div vue-entry=\"CoreHome.QuickAccess\"></div>
                <div vue-entry=\"CoreHome.ReportingMenu\"></div>
            </div>
        {% endif %}
        <div class=\"layoutWithSidebarContent\">
            <div class=\"top_controls\">
                {% block topcontrols %}
                {% endblock %}
            </div>

            <div class=\"page\">
                <div class=\"pageWrap\">
                    <div class=\"ui-confirm\" id=\"alert\">
                        <h2></h2>
                        <input role=\"yes\" type=\"button\" value=\"{{ 'General_Ok'|translate }}\"/>
                    </div>

                    {{ postEvent(\"Template.beforeContent\", \"dashboard\", currentModule, currentAction) }}

                    <a name=\"main\"></a>
                    {% block notification %}
                        {% include \"@CoreHome/_notifications.twig\" %}
                    {% endblock %}

                    <div vue-entry=\"CoreHome.Comparisons\"></div>

                    {% block content %}
                    {% endblock %}

                    <div class=\"clear\"></div>
                </div>
            </div>
        </div>
    </div>

{% if whatisnewShow is defined and whatisnewShow %}
    <script>
        document.addEventListener(\"DOMContentLoaded\", function(event) {
            const tooltip = '{{ 'CoreAdminHome_WhatIsNewTooltip'|translate }}';
            window.Piwik_Popover.createPopupAndLoadUrl('module=CoreAdminHome&action=whatIsNew', tooltip.replace(/&#039;/g,\"'\"), 'what-is-new-popup');
        });
    </script>
{% endif %}

{% endblock %}
", "dashboard.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Morpheus/templates/dashboard.twig");
    }
}
