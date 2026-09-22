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

/* @Dashboard/_widgetFactoryTemplate.twig */
class __TwigTemplate_949d5f5a1e656353954abd8c7ce3c1c4 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<div id=\"widgetTemplate\" style=\"display:none;\" vue-entry-ignore>
    ";
        // line 4
        yield "    <div class=\"widget __reportHeader-onHover\">
        ";
        // line 8
        yield "        <div class=\"widgetTop\">
            <div vue-entry=\"CoreHome.ReportHeader\" context=\"dashboard\"></div>
        </div>
        <div class=\"widgetContent\">
            <div class=\"widgetLoading\">";
        // line 12
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Dashboard_LoadingWidget"), "html", null, true);
        yield "</div>
        </div>
    </div>
</div>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@Dashboard/_widgetFactoryTemplate.twig";
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
        return array (  50 => 12,  44 => 8,  41 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div id=\"widgetTemplate\" style=\"display:none;\" vue-entry-ignore>
    {# `__reportHeader-onHover` is the ReportHeader context hook: it marks this widget as the
       hover scope, so hovering anywhere on it reveals the header controls (see ReportHeader.less). #}
    <div class=\"widget __reportHeader-onHover\">
        {# .widgetTop stays as the drag handle (see dashboardObject.js sortable `handle`).
           Its title + controls are rendered by the shared ReportHeader Vue component,
           hydrated per-widget in dashboardWidget.js with the widget name + context. #}
        <div class=\"widgetTop\">
            <div vue-entry=\"CoreHome.ReportHeader\" context=\"dashboard\"></div>
        </div>
        <div class=\"widgetContent\">
            <div class=\"widgetLoading\">{{ 'Dashboard_LoadingWidget'|translate }}</div>
        </div>
    </div>
</div>
", "@Dashboard/_widgetFactoryTemplate.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Dashboard/templates/_widgetFactoryTemplate.twig");
    }
}
