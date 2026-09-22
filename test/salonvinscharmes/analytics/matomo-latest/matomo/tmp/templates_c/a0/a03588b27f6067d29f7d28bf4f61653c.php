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

/* @Login/_whatsNewPanel.twig */
class __TwigTemplate_963e9603482219a90af0a4571fa1190b extends Template
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
        yield "<div class=\"loginWhatsNew\">
    <h2 class=\"loginWhatsNew__heading\">";
        // line 2
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("CoreAdminHome_WhatIsNewTitle"), "html", null, true);
        yield "</h2>

    ";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["changes"]) || array_key_exists("changes", $context) ? $context["changes"] : (function () { throw new RuntimeError('Variable "changes" does not exist.', 4, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["change"]) {
            // line 5
            yield "        <div class=\"loginWhatsNew__entry\">
            <h3 class=\"loginWhatsNew__title\">
                ";
            // line 7
            if (CoreExtension::getAttribute($this->env, $this->source, $context["change"], "showPluginPrefix", [], "any", false, false, false, 7)) {
                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["change"], "plugin_name", [], "any", false, false, false, 7), "html", null, true);
                yield " - ";
            }
            yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["change"], "title", [], "any", false, false, false, 7), "html", null, true);
            yield "
            </h3>

            ";
            // line 11
            yield "            <div class=\"loginWhatsNew__description\">";
            yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["change"], "description", [], "any", false, false, false, 11), "html", null, true);
            yield "</div>

            ";
            // line 13
            if (( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["change"], "link", [], "any", false, false, false, 13)) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["change"], "link_name", [], "any", false, false, false, 13)))) {
                // line 14
                yield "                <a class=\"loginWhatsNew__link\"
                   href=\"";
                // line 15
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('safelink')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, $context["change"], "link", [], "any", false, false, false, 15)), "html_attr");
                yield "\"
                   target=\"_blank\"
                   rel=\"noreferrer noopener\">";
                // line 17
                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["change"], "link_name", [], "any", false, false, false, 17), "html", null, true);
                yield "</a>
            ";
            }
            // line 19
            yield "        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['change'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        yield "</div>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@Login/_whatsNewPanel.twig";
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
        return array (  92 => 21,  85 => 19,  80 => 17,  75 => 15,  72 => 14,  70 => 13,  64 => 11,  54 => 7,  50 => 5,  46 => 4,  41 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"loginWhatsNew\">
    <h2 class=\"loginWhatsNew__heading\">{{ 'CoreAdminHome_WhatIsNewTitle'|translate }}</h2>

    {% for change in changes %}
        <div class=\"loginWhatsNew__entry\">
            <h3 class=\"loginWhatsNew__title\">
                {% if change.showPluginPrefix %}{{ change.plugin_name }} - {% endif %}{{ change.title }}
            </h3>

            {# Escaped, unlike the admin popover — this page is public. #}
            <div class=\"loginWhatsNew__description\">{{ change.description }}</div>

            {% if change.link is not empty and change.link_name is not empty %}
                <a class=\"loginWhatsNew__link\"
                   href=\"{{ change.link|safelink|e('html_attr') }}\"
                   target=\"_blank\"
                   rel=\"noreferrer noopener\">{{ change.link_name }}</a>
            {% endif %}
        </div>
    {% endfor %}
</div>
", "@Login/_whatsNewPanel.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Login/templates/_whatsNewPanel.twig");
    }
}
