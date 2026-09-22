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

/* @Installation/tablesCreation.twig */
class __TwigTemplate_25121402207ee38ee55a825138b01a0f extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@Installation/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("@Installation/layout.twig", "@Installation/tablesCreation.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        yield "
    <h2>";
        // line 5
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Installation_Tables"), "html", null, true);
        yield "</h2>

    ";
        // line 7
        if (array_key_exists("someTablesInstalled", $context)) {
            // line 8
            yield "        <div class=\"alert alert-warning\">
            ";
            // line 9
            yield $this->env->getFilter('translate')->getCallable()("Installation_TablesWithSameNamesFound", "<span id='linkToggle'>", "</span>");
            yield "
        </div>
        <p>
            ";
            // line 12
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Installation_TablesFound"), "html", null, true);
            yield ":
        </p>
        <p>
            <em>";
            // line 15
            yield \Piwik\piwik_escape_filter($this->env, (isset($context["tablesInstalled"]) || array_key_exists("tablesInstalled", $context) ? $context["tablesInstalled"] : (function () { throw new RuntimeError('Variable "tablesInstalled" does not exist.', 15, $this->source); })()), "html", null, true);
            yield " </em>
        </p>
        ";
            // line 17
            if (array_key_exists("showReuseExistingTables", $context)) {
                // line 18
                yield "            <p>";
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Installation_TablesWarningHelp"), "html", null, true);
                yield "</p>
            <p class=\"next-step\">
                <a href=\"";
                // line 20
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFunction('linkTo')->getCallable()(["action" => "reuseTables"]), "html", null, true);
                yield "\">";
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Installation_TablesReuse"), "html", null, true);
                yield " &raquo;</a>
            </p>
        ";
            } else {
                // line 23
                yield "            <p class=\"next-step\">
                <a href=\"";
                // line 24
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFunction('linkTo')->getCallable()(["action" => (isset($context["previousPreviousModuleName"]) || array_key_exists("previousPreviousModuleName", $context) ? $context["previousPreviousModuleName"] : (function () { throw new RuntimeError('Variable "previousPreviousModuleName" does not exist.', 24, $this->source); })())]), "html", null, true);
                yield "\">&laquo; ";
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Installation_GoBackAndDefinePrefix"), "html", null, true);
                yield "</a>
            </p>
        ";
            }
            // line 27
            yield "        <p class=\"next-step\">
            <a href=\"";
            // line 28
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFunction('linkTo')->getCallable()(["deleteTables" => 1]), "html", null, true);
            yield "\" id=\"eraseAllTables\">";
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Installation_TablesDelete"), "html", null, true);
            yield " &raquo;</a>
        </p>
    ";
        }
        // line 31
        yield "
    ";
        // line 32
        if (array_key_exists("existingTablesDeleted", $context)) {
            // line 33
            yield "        <div class=\"alert alert-success\">
            ";
            // line 34
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Installation_TablesDeletedSuccess"), "html", null, true);
            yield "
        </div>
    ";
        }
        // line 37
        yield "
    ";
        // line 38
        if (array_key_exists("tablesCreated", $context)) {
            // line 39
            yield "        <div class=\"alert alert-success\">
            ";
            // line 40
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Installation_TablesCreatedSuccess"), "html", null, true);
            yield "
        </div>
    ";
        }
        // line 43
        yield "
    <script>
        \$(document).ready(function () {
            var strConfirmEraseTables = \"";
        // line 46
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Installation_ConfirmDeleteExistingTables", (("[" . (isset($context["tablesInstalled"]) || array_key_exists("tablesInstalled", $context) ? $context["tablesInstalled"] : (function () { throw new RuntimeError('Variable "tablesInstalled" does not exist.', 46, $this->source); })())) . "]")), "html", null, true);
        yield " \";

            \$(\"#eraseAllTables\").click(function () {
                if (!confirm(strConfirmEraseTables)) {
                    return false;
                }
            });
        });
    </script>

";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@Installation/tablesCreation.twig";
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
        return array (  152 => 46,  147 => 43,  141 => 40,  138 => 39,  136 => 38,  133 => 37,  127 => 34,  124 => 33,  122 => 32,  119 => 31,  111 => 28,  108 => 27,  100 => 24,  97 => 23,  89 => 20,  83 => 18,  81 => 17,  76 => 15,  70 => 12,  64 => 9,  61 => 8,  59 => 7,  54 => 5,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends '@Installation/layout.twig' %}

{% block content %}

    <h2>{{ 'Installation_Tables'|translate }}</h2>

    {% if someTablesInstalled is defined %}
        <div class=\"alert alert-warning\">
            {{ 'Installation_TablesWithSameNamesFound'|translate(\"<span id='linkToggle'>\",\"</span>\")|raw }}
        </div>
        <p>
            {{ 'Installation_TablesFound'|translate }}:
        </p>
        <p>
            <em>{{ tablesInstalled }} </em>
        </p>
        {% if showReuseExistingTables is defined %}
            <p>{{ 'Installation_TablesWarningHelp'|translate }}</p>
            <p class=\"next-step\">
                <a href=\"{{ linkTo({'action':'reuseTables'}) }}\">{{ 'Installation_TablesReuse'|translate }} &raquo;</a>
            </p>
        {% else %}
            <p class=\"next-step\">
                <a href=\"{{ linkTo({'action':previousPreviousModuleName}) }}\">&laquo; {{ 'Installation_GoBackAndDefinePrefix'|translate }}</a>
            </p>
        {% endif %}
        <p class=\"next-step\">
            <a href=\"{{ linkTo({'deleteTables':1}) }}\" id=\"eraseAllTables\">{{ 'Installation_TablesDelete'|translate }} &raquo;</a>
        </p>
    {% endif %}

    {% if existingTablesDeleted is defined %}
        <div class=\"alert alert-success\">
            {{ 'Installation_TablesDeletedSuccess'|translate }}
        </div>
    {% endif %}

    {% if tablesCreated is defined %}
        <div class=\"alert alert-success\">
            {{ 'Installation_TablesCreatedSuccess'|translate }}
        </div>
    {% endif %}

    <script>
        \$(document).ready(function () {
            var strConfirmEraseTables = \"{{ 'Installation_ConfirmDeleteExistingTables'|translate(\"[\"~tablesInstalled~\"]\") }} \";

            \$(\"#eraseAllTables\").click(function () {
                if (!confirm(strConfirmEraseTables)) {
                    return false;
                }
            });
        });
    </script>

{% endblock %}", "@Installation/tablesCreation.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Installation/templates/tablesCreation.twig");
    }
}
