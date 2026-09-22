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

/* @CoreHome/_dataTableCell.twig */
class __TwigTemplate_58d5b38469e61eb58af351b3d35cbcc5 extends Template
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
        $___internal_parse_0_ = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 2
            $context["tooltipIndex"] = ((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 2, $this->source); })()) . "_tooltip");
            // line 3
            if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 3, $this->source); })()), "getMetadata", [(isset($context["tooltipIndex"]) || array_key_exists("tooltipIndex", $context) ? $context["tooltipIndex"] : (function () { throw new RuntimeError('Variable "tooltipIndex" does not exist.', 3, $this->source); })())], "method", false, false, false, 3)) {
                yield "<span class=\"cell-tooltip\" data-tooltip=\"";
                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 3, $this->source); })()), "getMetadata", [(isset($context["tooltipIndex"]) || array_key_exists("tooltipIndex", $context) ? $context["tooltipIndex"] : (function () { throw new RuntimeError('Variable "tooltipIndex" does not exist.', 3, $this->source); })())], "method", false, false, false, 3), "html", null, true);
                yield "\">";
            }
            // line 4
            if ((( !CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 4, $this->source); })()), "getIdSubDataTable", [], "method", false, false, false, 4) && ((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 4, $this->source); })()) == "label")) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 4, $this->source); })()), "getMetadata", ["url"], "method", false, false, false, 4))) {
                // line 5
                yield "    <a rel=\"noreferrer noopener\"
       target=\"_blank\"
       href='";
                // line 7
                if (!CoreExtension::inFilter(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 7, $this->source); })()), "getMetadata", ["url"], "method", false, false, false, 7), 0, 4), ["http", "ftp:"])) {
                    yield "http://";
                }
                yield $this->env->getFilter('rawSafeDecoded')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 7, $this->source); })()), "getMetadata", ["url"], "method", false, false, false, 7));
                yield "'>
";
            }
            // line 11
            $context["totals"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["dataTable"] ?? null), "getMetadata", ["totals"], "method", true, true, false, 11)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["dataTable"] ?? null), "getMetadata", ["totals"], "method", false, false, false, 11), ((array_key_exists("reportTotals", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["reportTotals"]) || array_key_exists("reportTotals", $context) ? $context["reportTotals"] : (function () { throw new RuntimeError('Variable "reportTotals" does not exist.', 11, $this->source); })()))) : ("")))) : (((array_key_exists("reportTotals", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["reportTotals"]) || array_key_exists("reportTotals", $context) ? $context["reportTotals"] : (function () { throw new RuntimeError('Variable "reportTotals" does not exist.', 11, $this->source); })()))) : (""))));
            // line 12
            $context["labelColumn"] = Twig\Extension\CoreExtension::first($this->env->getCharset(), (isset($context["columns_to_display"]) || array_key_exists("columns_to_display", $context) ? $context["columns_to_display"] : (function () { throw new RuntimeError('Variable "columns_to_display" does not exist.', 12, $this->source); })()));
            // line 13
            $context["reportLabel"] = $this->env->getFilter('rawSafeDecoded')->getCallable()($this->env->getFilter('truncate')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 13, $this->source); })()), "getColumn", [(isset($context["labelColumn"]) || array_key_exists("labelColumn", $context) ? $context["labelColumn"] : (function () { throw new RuntimeError('Variable "labelColumn" does not exist.', 13, $this->source); })())], "method", false, false, false, 13), 40));
            // line 15
            $context["showPercentageValues"] = ((((((CoreExtension::getAttribute($this->env, $this->source, ($context["properties"] ?? null), "show_percentage_values", [], "any", true, true, false, 15)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["properties"] ?? null), "show_percentage_values", [], "any", false, false, false, 15), false)) : (false)) && (((            // line 16
array_key_exists("rowId", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["rowId"]) || array_key_exists("rowId", $context) ? $context["rowId"] : (function () { throw new RuntimeError('Variable "rowId" does not exist.', 16, $this->source); })()))) : ("")) != "totalsRow")) && CoreExtension::inFilter(            // line 17
(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 17, $this->source); })()), ((CoreExtension::getAttribute($this->env, $this->source, ($context["properties"] ?? null), "report_ratio_columns", [], "any", true, true, false, 17)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["properties"] ?? null), "report_ratio_columns", [], "any", false, false, false, 17), [])) : ([])))) &&             // line 18
(isset($context["totals"]) || array_key_exists("totals", $context) ? $context["totals"] : (function () { throw new RuntimeError('Variable "totals" does not exist.', 18, $this->source); })())) && CoreExtension::inFilter((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 18, $this->source); })()), Twig\Extension\CoreExtension::keys((isset($context["totals"]) || array_key_exists("totals", $context) ? $context["totals"] : (function () { throw new RuntimeError('Variable "totals" does not exist.', 18, $this->source); })()))));
            // line 19
            $context["rowPercentage"] = "";
            // line 20
            if ((isset($context["showPercentageValues"]) || array_key_exists("showPercentageValues", $context) ? $context["showPercentageValues"] : (function () { throw new RuntimeError('Variable "showPercentageValues" does not exist.', 20, $this->source); })())) {
                // line 21
                if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 21, $this->source); })()), "getMetadata", [((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 21, $this->source); })()) . "_row_percentage")], "method", false, false, false, 21) != false)) {
                    // line 22
                    $context["rowPercentage"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 22, $this->source); })()), "getMetadata", [((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 22, $this->source); })()) . "_row_percentage")], "method", false, false, false, 22);
                } elseif (($this->env->getTest('numeric')->getCallable()(((CoreExtension::getAttribute($this->env, $this->source,                 // line 23
($context["row"] ?? null), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 23, $this->source); })())], "method", true, true, false, 23)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["row"] ?? null), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 23, $this->source); })())], "method", false, false, false, 23), 0)) : (0))) && $this->env->getTest('numeric')->getCallable()(((CoreExtension::getAttribute($this->env, $this->source, ($context["totals"] ?? null), (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 23, $this->source); })()), [], "array", true, true, false, 23)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["totals"] ?? null), (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 23, $this->source); })()), [], "array", false, false, false, 23), 0)) : (0))))) {
                    // line 24
                    $context["rowPercentage"] = $this->env->getFilter('percentage')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 24, $this->source); })()), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 24, $this->source); })())], "method", false, false, false, 24), CoreExtension::getAttribute($this->env, $this->source, (isset($context["totals"]) || array_key_exists("totals", $context) ? $context["totals"] : (function () { throw new RuntimeError('Variable "totals" does not exist.', 24, $this->source); })()), (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 24, $this->source); })()), [], "array", false, false, false, 24), 1);
                }
                // line 27
                $context["showPercentageValues"] =  !Twig\Extension\CoreExtension::testEmpty((isset($context["rowPercentage"]) || array_key_exists("rowPercentage", $context) ? $context["rowPercentage"] : (function () { throw new RuntimeError('Variable "rowPercentage" does not exist.', 27, $this->source); })()));
            }
            // line 29
            yield from             $this->loadTemplate("@CoreVisualizations/_dataTableViz_htmlTable_ratio.twig", "@CoreHome/_dataTableCell.twig", 29)->unwrap()->yield(CoreExtension::merge($context, ["label" =>             // line 30
(isset($context["reportLabel"]) || array_key_exists("reportLabel", $context) ? $context["reportLabel"] : (function () { throw new RuntimeError('Variable "reportLabel" does not exist.', 30, $this->source); })()), "labelColumn" =>             // line 31
(isset($context["labelColumn"]) || array_key_exists("labelColumn", $context) ? $context["labelColumn"] : (function () { throw new RuntimeError('Variable "labelColumn" does not exist.', 31, $this->source); })()), "translations" => CoreExtension::getAttribute($this->env, $this->source,             // line 32
(isset($context["properties"]) || array_key_exists("properties", $context) ? $context["properties"] : (function () { throw new RuntimeError('Variable "properties" does not exist.', 32, $this->source); })()), "translations", [], "any", false, false, false, 32), "rowPercentage" =>             // line 33
(isset($context["rowPercentage"]) || array_key_exists("rowPercentage", $context) ? $context["rowPercentage"] : (function () { throw new RuntimeError('Variable "rowPercentage" does not exist.', 33, $this->source); })()), "showAbsoluteValueOnHover" =>             // line 34
(isset($context["showPercentageValues"]) || array_key_exists("showPercentageValues", $context) ? $context["showPercentageValues"] : (function () { throw new RuntimeError('Variable "showPercentageValues" does not exist.', 34, $this->source); })())]));
            // line 36
            yield "
";
            // line 37
            $context["dimensions"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["dataTable"] ?? null), "getMetadata", ["dimensions"], "method", true, true, false, 37)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["dataTable"] ?? null), "getMetadata", ["dimensions"], "method", false, false, false, 37), [])) : ([]));
            // line 38
            if ((((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 38, $this->source); })()) == "label") || CoreExtension::inFilter((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 38, $this->source); })()), (isset($context["dimensions"]) || array_key_exists("dimensions", $context) ? $context["dimensions"] : (function () { throw new RuntimeError('Variable "dimensions" does not exist.', 38, $this->source); })())))) {
                // line 39
                yield "    ";
                $macros["piwik"] = $this->macros["piwik"] = $this->loadTemplate("macros.twig", "@CoreHome/_dataTableCell.twig", 39)->unwrap();
                // line 40
                yield "
    <span class='label";
                // line 41
                if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 41, $this->source); })()), "getMetadata", ["is_aggregate"], "method", false, false, false, 41)) {
                    yield " highlighted";
                }
                yield "'
    ";
                // line 42
                if ((array_key_exists("properties", $context) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, (isset($context["properties"]) || array_key_exists("properties", $context) ? $context["properties"] : (function () { throw new RuntimeError('Variable "properties" does not exist.', 42, $this->source); })()), "tooltip_metadata_name", [], "any", false, false, false, 42)))) {
                    yield "title=\"";
                    yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('rawSafeDecoded')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 42, $this->source); })()), "getMetadata", [CoreExtension::getAttribute($this->env, $this->source, (isset($context["properties"]) || array_key_exists("properties", $context) ? $context["properties"] : (function () { throw new RuntimeError('Variable "properties" does not exist.', 42, $this->source); })()), "tooltip_metadata_name", [], "any", false, false, false, 42)], "method", false, false, false, 42)), "html_attr");
                    yield "\"";
                }
                yield ">
        ";
                // line 43
                if (((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 43, $this->source); })()) == "label")) {
                    // line 44
                    yield "            ";
                    if ((( !CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 44, $this->source); })()), "getIdSubDataTable", [], "method", false, false, false, 44) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 44, $this->source); })()), "getMetadata", ["url"], "method", false, false, false, 44)) &&  !CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 44, $this->source); })()), "getMetadata", ["logo"], "method", false, false, false, 44))) {
                        // line 45
                        yield "                <span class=\"icon-outlink\"></span>
            ";
                    } else {
                        // line 47
                        yield "                ";
                        yield CoreExtension::callMacro($macros["piwik"], "macro_logoHtml", [CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 47, $this->source); })()), "getMetadata", [], "method", false, false, false, 47), CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 47, $this->source); })()), "getColumn", ["label"], "method", false, false, false, 47)], 47, $context, $this->getSourceContext());
                        yield "
            ";
                    }
                    // line 49
                    yield "        ";
                }
                // line 50
                yield "        ";
                if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 50, $this->source); })()), "getMetadata", ["html_label_prefix"], "method", false, false, false, 50)) {
                    yield "<span class='label-prefix'>";
                    yield CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 50, $this->source); })()), "getMetadata", ["html_label_prefix"], "method", false, false, false, 50);
                    yield "&nbsp;</span>";
                }
            }
            // line 51
            yield "<span class=\"value\">";
            // line 52
            if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 52, $this->source); })()), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 52, $this->source); })())], "method", false, false, false, 52) || (((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 52, $this->source); })()) == "label") && ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 52, $this->source); })()), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 52, $this->source); })())], "method", false, false, false, 52) === "0") || (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 52, $this->source); })()), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 52, $this->source); })())], "method", false, false, false, 52) === 0))))) {
                // line 53
                if (((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 53, $this->source); })()) == "label")) {
                    // line 54
                    yield $this->env->getFilter('rawSafeDecoded')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 54, $this->source); })()), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 54, $this->source); })())], "method", false, false, false, 54));
                } elseif (                // line 55
(isset($context["showPercentageValues"]) || array_key_exists("showPercentageValues", $context) ? $context["showPercentageValues"] : (function () { throw new RuntimeError('Variable "showPercentageValues" does not exist.', 55, $this->source); })())) {
                    // line 56
                    yield \Piwik\piwik_escape_filter($this->env, (isset($context["rowPercentage"]) || array_key_exists("rowPercentage", $context) ? $context["rowPercentage"] : (function () { throw new RuntimeError('Variable "rowPercentage" does not exist.', 56, $this->source); })()), "html", null, true);
                } else {
                    // line 58
                    if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 58, $this->source); })()), "getMetadata", [(("html_column_" . (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 58, $this->source); })())) . "_prefix")], "method", false, false, false, 58)) {
                        // line 59
                        yield "<span class='column-prefix'>";
                        yield CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 59, $this->source); })()), "getMetadata", [(("html_column_" . (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 59, $this->source); })())) . "_prefix")], "method", false, false, false, 59);
                        yield "</span>";
                    }
                    // line 61
                    yield $this->env->getFilter('rawSafeDecoded')->getCallable()($this->env->getFilter('number')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 61, $this->source); })()), "getColumn", [(isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 61, $this->source); })())], "method", false, false, false, 61), 2, 0));
                    // line 62
                    if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 62, $this->source); })()), "getMetadata", [(("html_column_" . (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 62, $this->source); })())) . "_suffix")], "method", false, false, false, 62)) {
                        // line 63
                        yield "<span class='column-suffix'>";
                        yield CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 63, $this->source); })()), "getMetadata", [(("html_column_" . (isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 63, $this->source); })())) . "_suffix")], "method", false, false, false, 63);
                        yield "</span>";
                    }
                }
            } else {
                // line 66
                yield "-";
            }
            // line 67
            yield "</span>
";
            // line 68
            if (((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 68, $this->source); })()) == "label")) {
                if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 68, $this->source); })()), "getMetadata", ["html_label_suffix"], "method", false, false, false, 68)) {
                    yield "<span class='label-suffix'>";
                    yield CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 68, $this->source); })()), "getMetadata", ["html_label_suffix"], "method", false, false, false, 68);
                    yield "</span>";
                }
                yield "</span>";
            }
            // line 69
            if ((( !CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 69, $this->source); })()), "getIdSubDataTable", [], "method", false, false, false, 69) && ((isset($context["column"]) || array_key_exists("column", $context) ? $context["column"] : (function () { throw new RuntimeError('Variable "column" does not exist.', 69, $this->source); })()) == "label")) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 69, $this->source); })()), "getMetadata", ["url"], "method", false, false, false, 69))) {
                // line 70
                yield "    </a>
";
            }
            // line 72
            if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["row"]) || array_key_exists("row", $context) ? $context["row"] : (function () { throw new RuntimeError('Variable "row" does not exist.', 72, $this->source); })()), "getMetadata", [(isset($context["tooltipIndex"]) || array_key_exists("tooltipIndex", $context) ? $context["tooltipIndex"] : (function () { throw new RuntimeError('Variable "tooltipIndex" does not exist.', 72, $this->source); })())], "method", false, false, false, 72)) {
                yield "</span>";
            }
            // line 73
            yield "
";
            return; yield '';
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 1
        yield Twig\Extension\CoreExtension::spaceless($___internal_parse_0_);
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@CoreHome/_dataTableCell.twig";
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
        return array (  210 => 1,  205 => 73,  201 => 72,  197 => 70,  195 => 69,  186 => 68,  183 => 67,  180 => 66,  173 => 63,  171 => 62,  169 => 61,  164 => 59,  162 => 58,  159 => 56,  157 => 55,  155 => 54,  153 => 53,  151 => 52,  149 => 51,  141 => 50,  138 => 49,  132 => 47,  128 => 45,  125 => 44,  123 => 43,  115 => 42,  109 => 41,  106 => 40,  103 => 39,  101 => 38,  99 => 37,  96 => 36,  94 => 34,  93 => 33,  92 => 32,  91 => 31,  90 => 30,  89 => 29,  86 => 27,  83 => 24,  81 => 23,  79 => 22,  77 => 21,  75 => 20,  73 => 19,  71 => 18,  70 => 17,  69 => 16,  68 => 15,  66 => 13,  64 => 12,  62 => 11,  54 => 7,  50 => 5,  48 => 4,  42 => 3,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% apply spaceless %}
{% set tooltipIndex = column ~ '_tooltip' %}
{% if row.getMetadata(tooltipIndex) %}<span class=\"cell-tooltip\" data-tooltip=\"{{ row.getMetadata(tooltipIndex) }}\">{% endif %}
{% if not row.getIdSubDataTable() and column=='label' and row.getMetadata('url') %}
    <a rel=\"noreferrer noopener\"
       target=\"_blank\"
       href='{% if row.getMetadata('url')|slice(0,4) not in ['http','ftp:'] %}http://{% endif %}{{ row.getMetadata('url')|rawSafeDecoded }}'>
{% endif %}

{#- an embedded subtable has no totals of its own, so it relates its rows to the report totals -#}
{% set totals = dataTable.getMetadata('totals')|default(reportTotals|default) %}
{% set labelColumn   = columns_to_display|first %}
{% set reportLabel   = row.getColumn(labelColumn)|truncate(40)|rawSafeDecoded %}
{#- the totals row is not part of the report rows, so its percentage would always be 100% -#}
{%- set showPercentageValues = properties.show_percentage_values|default(false)
    and rowId|default != 'totalsRow'
    and column in properties.report_ratio_columns|default([])
    and totals and column in totals|keys -%}
{%- set rowPercentage = '' -%}
{%- if showPercentageValues -%}
    {%- if row.getMetadata(column ~ '_row_percentage') != false -%}
        {%- set rowPercentage = row.getMetadata(column ~ '_row_percentage') -%}
    {%- elseif row.getColumn(column)|default(0) is numeric and totals[column]|default(0) is numeric -%}
        {%- set rowPercentage = row.getColumn(column)|percentage(totals[column], 1) -%}
    {%- endif -%}
    {#- with no percentage to show there is nothing to swap in, so the cell keeps its absolute value -#}
    {%- set showPercentageValues = rowPercentage is not empty -%}
{%- endif %}
{% include \"@CoreVisualizations/_dataTableViz_htmlTable_ratio.twig\" with {
    'label': reportLabel,
    'labelColumn': labelColumn,
    'translations': properties.translations,
    'rowPercentage': rowPercentage,
    'showAbsoluteValueOnHover': showPercentageValues
} %}

{% set dimensions = dataTable.getMetadata('dimensions')|default([]) %}
{% if column=='label' or column in dimensions %}
    {% import 'macros.twig' as piwik %}

    <span class='label{% if row.getMetadata('is_aggregate') %} highlighted{% endif %}'
    {% if properties is defined and properties.tooltip_metadata_name is not empty %}title=\"{{ row.getMetadata(properties.tooltip_metadata_name)|rawSafeDecoded|e('html_attr') }}\"{% endif %}>
        {% if column=='label' %}
            {% if not row.getIdSubDataTable() and row.getMetadata('url') and not row.getMetadata('logo') %}
                <span class=\"icon-outlink\"></span>
            {% else %}
                {{ piwik.logoHtml(row.getMetadata(), row.getColumn('label')) }}
            {% endif %}
        {% endif %}
        {% if row.getMetadata('html_label_prefix') %}<span class='label-prefix'>{{ row.getMetadata('html_label_prefix') | raw }}&nbsp;</span>{% endif -%}
{% endif %}<span class=\"value\">
    {%- if row.getColumn(column) or (column=='label' and (row.getColumn(column) is same as(\"0\") or row.getColumn(column) is same as(0))) -%}
        {%- if column=='label' -%}
            {{- row.getColumn(column)|rawSafeDecoded -}}
        {%- elseif showPercentageValues -%}
            {{- rowPercentage -}}
        {%- else -%}
            {%- if row.getMetadata('html_column_' ~ column ~ '_prefix') -%}
                <span class='column-prefix'>{{ row.getMetadata('html_column_' ~ column ~ '_prefix') | raw }}</span>
            {%- endif -%}
            {{- row.getColumn(column)|number(2,0)|rawSafeDecoded -}}
            {%- if row.getMetadata('html_column_' ~ column ~ '_suffix') -%}
                <span class='column-suffix'>{{ row.getMetadata('html_column_' ~ column ~ '_suffix') | raw }}</span>
            {%- endif -%}
        {%- endif -%}
    {%- else -%}-
    {%- endif -%}</span>
{% if column=='label' %}{%- if row.getMetadata('html_label_suffix') %}<span class='label-suffix'>{{ row.getMetadata('html_label_suffix') | raw }}</span>{% endif -%}</span>{% endif %}
{% if not row.getIdSubDataTable() and column=='label' and row.getMetadata('url') %}
    </a>
{% endif %}
{% if row.getMetadata(tooltipIndex) %}</span>{% endif %}

{% endapply %}
", "@CoreHome/_dataTableCell.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/CoreHome/templates/_dataTableCell.twig");
    }
}
