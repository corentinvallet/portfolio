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

/* @CoreVisualizations/_dataTableViz_htmlTable_ratio.twig */
class __TwigTemplate_d5985f9e9f1a27614cd91a08de78533c extends Template
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
        if ((CoreExtension::inFilter((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 1, $this->source); })()), CoreExtension::getAttribute($this->env, $this->source, (isset($context["properties"]) || array_key_exists("properties", $context) ? $context["properties"] : (function () { throw new RuntimeError('Variable "properties" does not exist.', 1, $this->source); })()), "report_ratio_columns", [], "any", false, false, false, 1)) && (CoreExtension::inFilter((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 1, $this->source); })()), Twig\Extension\CoreExtension::keys((isset($context["totals"]) || array_key_exists("totals", $context) ? $context["totals"] : (function () { throw new RuntimeError('Variable "totals" does not exist.', 1, $this->source); })()))) || ((array_key_exists("forceZero", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["forceZero"]) || array_key_exists("forceZero", $context) ? $context["forceZero"] : (function () { throw new RuntimeError('Variable "forceZero" does not exist.', 1, $this->source); })()))) : (""))))) {
            // line 2
            $context["reportTotal"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["totals"] ?? null), (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 2, $this->source); })()), [], "array", true, true, false, 2)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["totals"] ?? null), (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 2, $this->source); })()), [], "array", false, false, false, 2), 0)) : (0));
            // line 3
            yield "
    ";
            // line 4
            if ((array_key_exists("siteTotalRow", $context) &&  !Twig\Extension\CoreExtension::testEmpty((isset($context["siteTotalRow"]) || array_key_exists("siteTotalRow", $context) ? $context["siteTotalRow"] : (function () { throw new RuntimeError('Variable "siteTotalRow" does not exist.', 4, $this->source); })())))) {
                // line 5
                yield "        ";
                $context["siteTotal"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["siteTotalRow"]) || array_key_exists("siteTotalRow", $context) ? $context["siteTotalRow"] : (function () { throw new RuntimeError('Variable "siteTotalRow" does not exist.', 5, $this->source); })()), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 5, $this->source); })())], "method", false, false, false, 5);
                // line 6
                yield "    ";
            } else {
                // line 7
                yield "        ";
                $context["siteTotal"] = 0;
                // line 8
                yield "    ";
            }
            // line 9
            yield "
    ";
            // line 10
            if (Twig\Extension\CoreExtension::testEmpty(((array_key_exists("rowPercentage", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["rowPercentage"]) || array_key_exists("rowPercentage", $context) ? $context["rowPercentage"] : (function () { throw new RuntimeError('Variable "rowPercentage" does not exist.', 10, $this->source); })()))) : ("")))) {
                // line 11
                yield "        ";
                if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 11, $this->source); })()), "getMetadata", [((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 11, $this->source); })()) . "_row_percentage")], "method", false, false, false, 11) != false)) {
                    // line 12
                    yield "            ";
                    $context["rowPercentage"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 12, $this->source); })()), "getMetadata", [((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 12, $this->source); })()) . "_row_percentage")], "method", false, false, false, 12);
                    // line 13
                    yield "        ";
                } elseif (($this->env->getTest('numeric')->getCallable()(((CoreExtension::getAttribute($this->env, $this->source, ($context["row"] ?? null), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 13, $this->source); })())], "method", true, true, false, 13)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["row"] ?? null), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 13, $this->source); })())], "method", false, false, false, 13), 0)) : (0))) && $this->env->getTest('numeric')->getCallable()((isset($context["reportTotal"]) || array_key_exists("reportTotal", $context) ? $context["reportTotal"] : (function () { throw new RuntimeError('Variable "reportTotal" does not exist.', 13, $this->source); })())))) {
                    // line 14
                    yield "            ";
                    $context["rowPercentage"] = $this->env->getFilter('percentage')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 14, $this->source); })()), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 14, $this->source); })())], "method", false, false, false, 14), (isset($context["reportTotal"]) || array_key_exists("reportTotal", $context) ? $context["reportTotal"] : (function () { throw new RuntimeError('Variable "reportTotal" does not exist.', 14, $this->source); })()), 1);
                    // line 15
                    yield "        ";
                } else {
                    // line 16
                    yield "            ";
                    $context["rowPercentage"] = "";
                    yield " ";
                    // line 17
                    yield "        ";
                }
                // line 18
                yield "    ";
            }
            // line 19
            yield "
    ";
            // line 20
            $context["metricTitle"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["translations"] ?? null), (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 20, $this->source); })()), [], "array", true, true, false, 20)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["translations"] ?? null), (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 20, $this->source); })()), [], "array", false, false, false, 20), (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 20, $this->source); })()))) : ((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 20, $this->source); })())));
            // line 21
            yield "
    ";
            // line 22
            $context["reportRatioTooltip"] = $this->env->getFilter('translate')->getCallable()("General_ReportRatioTooltip", (isset($context["label"]) || array_key_exists("label", $context) ? $context["label"] : (function () { throw new RuntimeError('Variable "label" does not exist.', 22, $this->source); })()), (isset($context["rowPercentage"]) || array_key_exists("rowPercentage", $context) ? $context["rowPercentage"] : (function () { throw new RuntimeError('Variable "rowPercentage" does not exist.', 22, $this->source); })()), (isset($context["reportTotal"]) || array_key_exists("reportTotal", $context) ? $context["reportTotal"] : (function () { throw new RuntimeError('Variable "reportTotal" does not exist.', 22, $this->source); })()), (isset($context["metricTitle"]) || array_key_exists("metricTitle", $context) ? $context["metricTitle"] : (function () { throw new RuntimeError('Variable "metricTitle" does not exist.', 22, $this->source); })()), (("\"" . (isset($context["segmentTitlePretty"]) || array_key_exists("segmentTitlePretty", $context) ? $context["segmentTitlePretty"] : (function () { throw new RuntimeError('Variable "segmentTitlePretty" does not exist.', 22, $this->source); })())) . "\""), ((CoreExtension::getAttribute($this->env, $this->source, ($context["translations"] ?? null), (isset($context["labelColumn"]) || array_key_exists("labelColumn", $context) ? $context["labelColumn"] : (function () { throw new RuntimeError('Variable "labelColumn" does not exist.', 22, $this->source); })()), [], "array", true, true, false, 22)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["translations"] ?? null), (isset($context["labelColumn"]) || array_key_exists("labelColumn", $context) ? $context["labelColumn"] : (function () { throw new RuntimeError('Variable "labelColumn" does not exist.', 22, $this->source); })()), [], "array", false, false, false, 22), (isset($context["labelColumn"]) || array_key_exists("labelColumn", $context) ? $context["labelColumn"] : (function () { throw new RuntimeError('Variable "labelColumn" does not exist.', 22, $this->source); })()))) : ((isset($context["labelColumn"]) || array_key_exists("labelColumn", $context) ? $context["labelColumn"] : (function () { throw new RuntimeError('Variable "labelColumn" does not exist.', 22, $this->source); })()))));
            // line 23
            yield "
    ";
            // line 24
            if (Twig\Extension\CoreExtension::testEmpty(((array_key_exists("totalPercentage", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["totalPercentage"]) || array_key_exists("totalPercentage", $context) ? $context["totalPercentage"] : (function () { throw new RuntimeError('Variable "totalPercentage" does not exist.', 24, $this->source); })()))) : ("")))) {
                // line 25
                yield "        ";
                if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 25, $this->source); })()), "getMetadata", [((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 25, $this->source); })()) . "_site_total_percentage")], "method", false, false, false, 25) != false)) {
                    // line 26
                    yield "            ";
                    $context["totalPercentage"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 26, $this->source); })()), "getMetadata", [((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 26, $this->source); })()) . "_site_total_percentage")], "method", false, false, false, 26);
                } elseif ((($this->env->getTest('numeric')->getCallable()(((CoreExtension::getAttribute($this->env, $this->source,                 // line 28
($context["row"] ?? null), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 28, $this->source); })())], "method", true, true, false, 28)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["row"] ?? null), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 28, $this->source); })())], "method", false, false, false, 28), 0)) : (0))) && $this->env->getTest('numeric')->getCallable()((isset($context["siteTotal"]) || array_key_exists("siteTotal", $context) ? $context["siteTotal"] : (function () { throw new RuntimeError('Variable "siteTotal" does not exist.', 28, $this->source); })()))) && ((isset($context["siteTotal"]) || array_key_exists("siteTotal", $context) ? $context["siteTotal"] : (function () { throw new RuntimeError('Variable "siteTotal" does not exist.', 28, $this->source); })()) > 0))) {
                    // line 29
                    yield "            ";
                    $context["totalPercentage"] = $this->env->getFilter('percentage')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 29, $this->source); })()), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 29, $this->source); })())], "method", false, false, false, 29), (isset($context["siteTotal"]) || array_key_exists("siteTotal", $context) ? $context["siteTotal"] : (function () { throw new RuntimeError('Variable "siteTotal" does not exist.', 29, $this->source); })()), 1);
                    // line 30
                    yield "        ";
                }
                // line 31
                yield "    ";
            }
            // line 32
            yield "
    ";
            // line 33
            if ( !Twig\Extension\CoreExtension::testEmpty(((array_key_exists("totalPercentage", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["totalPercentage"]) || array_key_exists("totalPercentage", $context) ? $context["totalPercentage"] : (function () { throw new RuntimeError('Variable "totalPercentage" does not exist.', 33, $this->source); })()))) : ("")))) {
                // line 34
                yield "        ";
                $context["totalRatioTooltip"] = $this->env->getFilter('translate')->getCallable()("General_TotalRatioTooltip", (isset($context["totalPercentage"]) || array_key_exists("totalPercentage", $context) ? $context["totalPercentage"] : (function () { throw new RuntimeError('Variable "totalPercentage" does not exist.', 34, $this->source); })()), $this->env->getFilter('number')->getCallable()((isset($context["siteTotal"]) || array_key_exists("siteTotal", $context) ? $context["siteTotal"] : (function () { throw new RuntimeError('Variable "siteTotal" does not exist.', 34, $this->source); })()), 2, 0), ((((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 34, $this->source); })()) == "nb_visits")) ? ($this->env->getFilter('translate')->getCallable()("General_ColumnNbVisits")) : ((isset($context["metricTitle"]) || array_key_exists("metricTitle", $context) ? $context["metricTitle"] : (function () { throw new RuntimeError('Variable "metricTitle" does not exist.', 34, $this->source); })()))), (isset($context["periodTitlePretty"]) || array_key_exists("periodTitlePretty", $context) ? $context["periodTitlePretty"] : (function () { throw new RuntimeError('Variable "periodTitlePretty" does not exist.', 34, $this->source); })()));
                // line 35
                yield "    ";
            } else {
                // line 36
                yield "        ";
                $context["totalRatioTooltip"] = "";
                // line 37
                yield "    ";
            }
            // line 41
            yield "<span class=\"ratio\"
          title=\"";
            // line 42
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('rawSafeDecoded')->getCallable()((isset($context["reportRatioTooltip"]) || array_key_exists("reportRatioTooltip", $context) ? $context["reportRatioTooltip"] : (function () { throw new RuntimeError('Variable "reportRatioTooltip" does not exist.', 42, $this->source); })())), "html_attr");
            yield " ";
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('rawSafeDecoded')->getCallable()((isset($context["totalRatioTooltip"]) || array_key_exists("totalRatioTooltip", $context) ? $context["totalRatioTooltip"] : (function () { throw new RuntimeError('Variable "totalRatioTooltip" does not exist.', 42, $this->source); })())), "html_attr");
            if ( !Twig\Extension\CoreExtension::testEmpty(((array_key_exists("tooltipSuffix", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["tooltipSuffix"]) || array_key_exists("tooltipSuffix", $context) ? $context["tooltipSuffix"] : (function () { throw new RuntimeError('Variable "tooltipSuffix" does not exist.', 42, $this->source); })()))) : ("")))) {
                yield "<br/><br/> ";
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('rawSafeDecoded')->getCallable()((isset($context["tooltipSuffix"]) || array_key_exists("tooltipSuffix", $context) ? $context["tooltipSuffix"] : (function () { throw new RuntimeError('Variable "tooltipSuffix" does not exist.', 42, $this->source); })())), "html_attr");
            }
            yield "\"
    >&nbsp;";
            // line 44
            if (((array_key_exists("showAbsoluteValueOnHover", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["showAbsoluteValueOnHover"]) || array_key_exists("showAbsoluteValueOnHover", $context) ? $context["showAbsoluteValueOnHover"] : (function () { throw new RuntimeError('Variable "showAbsoluteValueOnHover" does not exist.', 44, $this->source); })()))) : (""))) {
                // line 45
                if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 45, $this->source); })()), "getMetadata", [(("html_column_" . (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 45, $this->source); })())) . "_prefix")], "method", false, false, false, 45)) {
                    // line 46
                    yield "<span class='column-prefix'>";
                    yield CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 46, $this->source); })()), "getMetadata", [(("html_column_" . (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 46, $this->source); })())) . "_prefix")], "method", false, false, false, 46);
                    yield "</span>";
                }
                // line 48
                yield $this->env->getFilter('rawSafeDecoded')->getCallable()($this->env->getFilter('number')->getCallable()(((CoreExtension::getAttribute($this->env, $this->source, ($context["row"] ?? null), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 48, $this->source); })())], "method", true, true, false, 48)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["row"] ?? null), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 48, $this->source); })())], "method", false, false, false, 48), 0)) : (0)), 2, 0));
                // line 49
                if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 49, $this->source); })()), "getMetadata", [(("html_column_" . (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 49, $this->source); })())) . "_suffix")], "method", false, false, false, 49)) {
                    // line 50
                    yield "<span class='column-suffix'>";
                    yield CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 50, $this->source); })()), "getMetadata", [(("html_column_" . (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 50, $this->source); })())) . "_suffix")], "method", false, false, false, 50);
                    yield "</span>";
                }
            } else {
                // line 53
                yield \Piwik\piwik_escape_filter($this->env, (isset($context["rowPercentage"]) || array_key_exists("rowPercentage", $context) ? $context["rowPercentage"] : (function () { throw new RuntimeError('Variable "rowPercentage" does not exist.', 53, $this->source); })()), "html", null, true);
            }
            // line 54
            yield " ";
            if ( !Twig\Extension\CoreExtension::testEmpty(((array_key_exists("changePercentage", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["changePercentage"]) || array_key_exists("changePercentage", $context) ? $context["changePercentage"] : (function () { throw new RuntimeError('Variable "changePercentage" does not exist.', 54, $this->source); })()))) : ("")))) {
                yield "(";
                yield \Piwik\piwik_escape_filter($this->env, (isset($context["changePercentage"]) || array_key_exists("changePercentage", $context) ? $context["changePercentage"] : (function () { throw new RuntimeError('Variable "changePercentage" does not exist.', 54, $this->source); })()), "html", null, true);
                yield ")";
            }
            yield "</span>";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@CoreVisualizations/_dataTableViz_htmlTable_ratio.twig";
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
        return array (  173 => 54,  170 => 53,  164 => 50,  162 => 49,  160 => 48,  155 => 46,  153 => 45,  151 => 44,  141 => 42,  138 => 41,  135 => 37,  132 => 36,  129 => 35,  126 => 34,  124 => 33,  121 => 32,  118 => 31,  115 => 30,  112 => 29,  110 => 28,  107 => 26,  104 => 25,  102 => 24,  99 => 23,  97 => 22,  94 => 21,  92 => 20,  89 => 19,  86 => 18,  83 => 17,  79 => 16,  76 => 15,  73 => 14,  70 => 13,  67 => 12,  64 => 11,  62 => 10,  59 => 9,  56 => 8,  53 => 7,  50 => 6,  47 => 5,  45 => 4,  42 => 3,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% if column in properties.report_ratio_columns and (column in totals|keys or forceZero|default) -%}
    {% set reportTotal   = totals[column]|default(0) %}

    {% if siteTotalRow is defined and siteTotalRow is not empty %}
        {% set siteTotal = siteTotalRow.getColumn(column) %}
    {% else %}
        {% set siteTotal = 0 %}
    {% endif %}

    {% if rowPercentage|default is empty %}
        {% if row.getMetadata(column ~ '_row_percentage') != false %}
            {% set rowPercentage = row.getMetadata(column ~ '_row_percentage') %}
        {% elseif row.getColumn(column)|default(0) is numeric and reportTotal is numeric %}
            {% set rowPercentage = row.getColumn(column)|percentage(reportTotal, 1) %}
        {% else %}
            {% set rowPercentage = '' %} {# should not happen #}
        {% endif %}
    {% endif %}

    {% set metricTitle   = translations[column]|default(column) %}

    {% set reportRatioTooltip = 'General_ReportRatioTooltip'|translate(label, rowPercentage, reportTotal, metricTitle, '\"' ~ segmentTitlePretty ~ '\"', translations[labelColumn]|default(labelColumn)) %}

    {% if totalPercentage|default is empty %}
        {% if row.getMetadata(column ~ '_site_total_percentage') != false %}
            {% set totalPercentage = row.getMetadata(column ~ '_site_total_percentage') %}
        {#- without a site summary row siteTotal falls back to 0, which is no total to relate a row to -#}
        {% elseif row.getColumn(column)|default(0) is numeric and siteTotal is numeric and siteTotal > 0 %}
            {% set totalPercentage = row.getColumn(column)|percentage(siteTotal, 1) %}
        {% endif %}
    {% endif %}

    {% if totalPercentage|default is not empty %}
        {% set totalRatioTooltip = 'General_TotalRatioTooltip'|translate(totalPercentage, siteTotal|number(2,0), column == 'nb_visits' ? 'General_ColumnNbVisits'|translate : metricTitle, periodTitlePretty) %}
    {% else %}
        {% set totalRatioTooltip = '' %}
    {% endif %}

    {#- the tooltip is rendered as HTML from this attribute, and the browser decodes the attribute
        again when it is read back, so every value interpolated here is escaped exactly once -#}
    <span class=\"ratio\"
          title=\"{{ reportRatioTooltip|rawSafeDecoded|e('html_attr') }} {{ totalRatioTooltip|rawSafeDecoded|e('html_attr') }}{% if tooltipSuffix|default is not empty %}<br/><br/> {{ tooltipSuffix|rawSafeDecoded|e('html_attr') }}{% endif %}\"
    >&nbsp;
        {%- if showAbsoluteValueOnHover|default -%}
            {%- if row.getMetadata('html_column_' ~ column ~ '_prefix') -%}
                <span class='column-prefix'>{{ row.getMetadata('html_column_' ~ column ~ '_prefix') | raw }}</span>
            {%- endif -%}
            {{- row.getColumn(column)|default(0)|number(2,0)|rawSafeDecoded -}}
            {%- if row.getMetadata('html_column_' ~ column ~ '_suffix') -%}
                <span class='column-suffix'>{{ row.getMetadata('html_column_' ~ column ~ '_suffix') | raw }}</span>
            {%- endif -%}
        {%- else -%}
            {{- rowPercentage -}}
        {%- endif %} {% if changePercentage|default is not empty %}({{ changePercentage }}){% endif %}</span>
{%- endif %}
", "@CoreVisualizations/_dataTableViz_htmlTable_ratio.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/CoreVisualizations/templates/_dataTableViz_htmlTable_ratio.twig");
    }
}
