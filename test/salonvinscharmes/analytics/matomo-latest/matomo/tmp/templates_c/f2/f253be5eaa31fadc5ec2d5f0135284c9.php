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

/* @Live/getLastVisitsStart.twig */
class __TwigTemplate_e9c2124644a917da01a2bea8221c9788 extends Template
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
        // line 2
        $context["maxPagesDisplayedByVisitor"] = 100;
        // line 3
        yield "
";
        // line 4
        if ( !Twig\Extension\CoreExtension::testEmpty((isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 4, $this->source); })()))) {
            // line 5
            yield "<div vue-entry=\"CoreHome.Alert\" severity=\"danger\">";
            yield \Piwik\piwik_escape_filter($this->env, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 5, $this->source); })()), "html", null, true);
            yield "</div>
";
        } else {
            // line 7
            yield "<ul id=\"visitsLive\">
    ";
            // line 8
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["visitors"]) || array_key_exists("visitors", $context) ? $context["visitors"] : (function () { throw new RuntimeError('Variable "visitors" does not exist.', 8, $this->source); })()), "getRows", [], "method", false, false, false, 8));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["visitor"]) {
                // line 9
                yield "        <li id=\"vid";
                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["idVisit"], "method", false, false, false, 9), "html", null, true);
                yield "\" class=\"visit\" data-hash=\"";
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('md5')->getCallable()(json_encode($context["visitor"])), "html", null, true);
                yield "\">
            <div style=\"display:none;\" class=\"idvisit\">";
                // line 10
                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "idVisit", [], "any", false, false, false, 10), "html", null, true);
                yield "</div>
            <div class=\"datetime\">
                <span style=\"display:none;\" class=\"serverTimestamp\">";
                // line 12
                yield CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["serverTimestamp"], "method", false, false, false, 12);
                yield "</span>
                ";
                // line 13
                yield $this->env->getFunction('postEvent')->getCallable()("Live.visitorLogWidgetViewBeforeVisitInfo", $context["visitor"]);
                yield "
                ";
                // line 14
                $context["year"] = $this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["serverTimestamp"], "method", false, false, false, 14), "Y");
                // line 15
                yield "                <span class=\"realTimeWidget_datetime\">";
                yield \Piwik\piwik_escape_filter($this->env, Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["serverDatePretty"], "method", false, false, false, 15), [(isset($context["year"]) || array_key_exists("year", $context) ? $context["year"] : (function () { throw new RuntimeError('Variable "year" does not exist.', 15, $this->source); })()) => " "]), "html", null, true);
                yield " - ";
                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["serverTimePretty"], "method", false, false, false, 15), "html", null, true);
                yield " ";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["visitDuration"], "method", false, false, false, 15) > 0)) {
                    yield "(";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["visitDurationPretty"], "method", false, false, false, 15);
                    yield ")";
                }
                yield "</span>

                ";
                // line 17
                yield $this->env->getFunction('postEvent')->getCallable()("Live.renderVisitorIcons", $context["visitor"]);
                yield "
                ";
                // line 18
                if (((isset($context["isProfileEnabled"]) || array_key_exists("isProfileEnabled", $context) ? $context["isProfileEnabled"] : (function () { throw new RuntimeError('Variable "isProfileEnabled" does not exist.', 18, $this->source); })()) &&  !(isset($context["userIsAnonymous"]) || array_key_exists("userIsAnonymous", $context) ? $context["userIsAnonymous"] : (function () { throw new RuntimeError('Variable "userIsAnonymous" does not exist.', 18, $this->source); })()))) {
                    // line 19
                    yield "                    <a class=\"visits-live-launch-visitor-profile rightLink\" title=\"";
                    yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Live_ViewVisitorProfile"), "html", null, true);
                    yield " ";
                    if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["userId"], "method", false, false, false, 19))) {
                        yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["userId"], "method", false, false, false, 19), "html", null, true);
                    }
                    yield "\" data-visitor-id=\"";
                    yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["visitorId"], "method", false, false, false, 19), "html", null, true);
                    yield "\">
                        <span class=\"icon-visitor-profile\"></span>
                    </a>
                ";
                }
                // line 23
                yield "
                <span class=\"referrer\">
                    ";
                // line 25
                yield from                 $this->loadTemplate("@Referrers/_visitorDetails.twig", "@Live/getLastVisitsStart.twig", 25)->unwrap()->yield(CoreExtension::merge($context, ["visitInfo" => $context["visitor"]]));
                // line 26
                yield "                 </span>

                ";
                // line 28
                if ( !Twig\Extension\CoreExtension::testEmpty(((CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["userId"], "method", true, true, false, 28)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["userId"], "method", false, false, false, 28), false)) : (false)))) {
                    // line 29
                    yield "                    <a class=\"visits-live-launch-visitor-profile rightLink\" title=\"";
                    yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Live_ViewVisitorProfile"), "html", null, true);
                    yield " ";
                    if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["userId"], "method", false, false, false, 29))) {
                        yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["userId"], "method", false, false, false, 29), "html", null, true);
                    }
                    yield "\" data-visitor-id=\"";
                    yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["visitorId"], "method", false, false, false, 29), "html", null, true);
                    yield "\">
                        <span>";
                    // line 30
                    yield $this->env->getFilter('rawSafeDecoded')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["userId"], "method", false, false, false, 30));
                    yield "</span>
                    </a>
                ";
                }
                // line 33
                yield "
            </div>
            <div id=\"actions_";
                // line 35
                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["idVisit"], "method", false, false, false, 35), "html", null, true);
                yield "\" class=\"settings\">
                <span class=\"pagesTitle\"
                      title=\"";
                // line 37
                yield \Piwik\piwik_escape_filter($this->env, Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["actionDetails"], "method", false, false, false, 37)), "html", null, true);
                yield " ";
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Actions"), "html", null, true);
                yield "\"
                      >";
                // line 38
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Actions"), "html", null, true);
                yield ":</span>&nbsp;
                ";
                // line 39
                $context["col"] = 0;
                // line 40
                yield "                ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["actionDetails"], "method", false, false, false, 40));
                $context['loop'] = [
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                ];
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["action"]) {
                    // line 41
                    yield "                    ";
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 41) <= (isset($context["maxPagesDisplayedByVisitor"]) || array_key_exists("maxPagesDisplayedByVisitor", $context) ? $context["maxPagesDisplayedByVisitor"] : (function () { throw new RuntimeError('Variable "maxPagesDisplayedByVisitor" does not exist.', 41, $this->source); })()))) {
                        // line 42
                        yield "
                        ";
                        // line 43
                        if (((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "type", [], "any", false, false, false, 43) == "ecommerceOrder") || (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "type", [], "any", false, false, false, 43) == "ecommerceAbandonedCart"))) {
                            // line 44
                            yield "                            ";
                            $context["title"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                                // line 45
                                if ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "type", [], "any", false, false, false, 45) == "ecommerceOrder")) {
                                    // line 46
                                    yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Goals_EcommerceOrder"), "html", null, true);
                                } else {
                                    // line 48
                                    yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Goals_AbandonedCart"), "html", null, true);
                                }
                                // line 50
                                yield "
 - ";
                                // line 51
                                if ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "type", [], "any", false, false, false, 51) == "ecommerceOrder")) {
                                    // line 52
                                    yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_ColumnRevenue"), "html", null, true);
                                    yield ":";
                                } else {
                                    // line 54
                                    $context["revenueLeft"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                                        // line 55
                                        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_ColumnRevenue"), "html", null, true);
                                        return; yield '';
                                    })())) ? '' : new Markup($tmp, $this->env->getCharset());
                                    // line 57
                                    yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Goals_LeftInCart", (isset($context["revenueLeft"]) || array_key_exists("revenueLeft", $context) ? $context["revenueLeft"] : (function () { throw new RuntimeError('Variable "revenueLeft" does not exist.', 57, $this->source); })())), "html", null, true);
                                    yield ":";
                                }
                                // line 58
                                yield " ";
                                yield $this->env->getFilter('money')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "revenue", [], "any", false, false, false, 58), (isset($context["idSite"]) || array_key_exists("idSite", $context) ? $context["idSite"] : (function () { throw new RuntimeError('Variable "idSite" does not exist.', 58, $this->source); })()));
                                // line 60
                                yield "
 - ";
                                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "serverTimePretty", [], "any", false, false, false, 60), "html", null, true);
                                // line 61
                                yield "
";
                                // line 62
                                if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "itemDetails", [], "any", false, false, false, 62))) {
                                    // line 63
                                    $context['_parent'] = $context;
                                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "itemDetails", [], "any", false, false, false, 63));
                                    foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
                                        // line 64
                                        yield "
# ";
                                        yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["product"], "itemSKU", [], "any", false, false, false, 64), "html", null, true);
                                        if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "itemName", [], "any", false, false, false, 64))) {
                                            yield ": ";
                                            yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["product"], "itemName", [], "any", false, false, false, 64), "html", null, true);
                                        }
                                        if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "itemCategory", [], "any", false, false, false, 64))) {
                                            yield " (";
                                            yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["product"], "itemCategory", [], "any", false, false, false, 64), "html", null, true);
                                            yield ")";
                                        }
                                        yield ", ";
                                        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Quantity"), "html", null, true);
                                        yield ": ";
                                        yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 64), "html", null, true);
                                        yield ", ";
                                        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Price"), "html", null, true);
                                        yield ": ";
                                        yield $this->env->getFilter('money')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 64), (isset($context["idSite"]) || array_key_exists("idSite", $context) ? $context["idSite"] : (function () { throw new RuntimeError('Variable "idSite" does not exist.', 64, $this->source); })()));
                                    }
                                    $_parent = $context['_parent'];
                                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
                                    $context = array_intersect_key($context, $_parent) + $_parent;
                                }
                                // line 67
                                yield "                            ";
                                return; yield '';
                            })())) ? '' : new Markup($tmp, $this->env->getCharset());
                            // line 68
                            yield "                            <span title=\"";
                            yield \Piwik\piwik_escape_filter($this->env, (isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 68, $this->source); })()), "html");
                            yield "\">
                                <img class='iconPadding' src=\"";
                            // line 69
                            yield \Piwik\piwik_escape_filter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", true, true, false, 69)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", false, false, false, 69), CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 69))) : (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 69))), "html", null, true);
                            yield "\"/>
                                ";
                            // line 70
                            if ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "type", [], "any", false, false, false, 70) == "ecommerceOrder")) {
                                // line 71
                                yield "                                    ";
                                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_ColumnRevenue"), "html", null, true);
                                yield ": ";
                                yield $this->env->getFilter('money')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "revenue", [], "any", false, false, false, 71), (isset($context["idSite"]) || array_key_exists("idSite", $context) ? $context["idSite"] : (function () { throw new RuntimeError('Variable "idSite" does not exist.', 71, $this->source); })()));
                                yield "
                                ";
                            }
                            // line 73
                            yield "                            </span>

                        ";
                        } else {
                            // line 76
                            yield "
                            ";
                            // line 77
                            if ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "url", [], "any", true, true, false, 77) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "url", [], "any", false, false, false, 77)))) {
                                // line 78
                                yield "                            <a href=\"";
                                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('safelink')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "url", [], "any", false, false, false, 78)), "html_attr");
                                yield "\" target=\"_blank\" rel=\"noreferrer noopener\">
                            ";
                            }
                            // line 80
                            yield "                                ";
                            if ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "type", [], "any", false, false, false, 80) == "action")) {
                                // line 82
                                $context["title"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                                    // line 83
                                    if ( !Twig\Extension\CoreExtension::testEmpty(Twig\Extension\CoreExtension::trim(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "url", [], "any", false, false, false, 83)))) {
                                        yield "<span>";
                                        yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "url", [], "any", false, false, false, 83), "html", null, true);
                                        yield "</span>";
                                    }
                                    // line 84
                                    yield "
";
                                    // line 85
                                    if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "pageTitle", [], "any", false, false, false, 85))) {
                                        yield "<span>";
                                        yield $this->env->getFilter('rawSafeDecoded')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "pageTitle", [], "any", false, false, false, 85));
                                        yield "</span>";
                                    }
                                    // line 86
                                    yield "
<span>";
                                    // line 87
                                    yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "serverTimePretty", [], "any", false, false, false, 87), "html", null, true);
                                    yield "</span>
    ";
                                    // line 88
                                    if (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "timeSpentPretty", [], "any", true, true, false, 88)) {
                                        yield "<span>";
                                        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_TimeOnPage"), "html", null, true);
                                        yield ": ";
                                        yield CoreExtension::getAttribute($this->env, $this->source, $context["action"], "timeSpentPretty", [], "any", false, false, false, 88);
                                        yield "</span>";
                                    }
                                    return; yield '';
                                })())) ? '' : new Markup($tmp, $this->env->getCharset());
                                // line 90
                                yield "                                    <img class='iconPadding' src=\"";
                                yield \Piwik\piwik_escape_filter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", true, true, false, 90)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", false, false, false, 90), CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 90))) : (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 90))), "html", null, true);
                                yield "\" title=\"";
                                yield \Piwik\piwik_escape_filter($this->env, (isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 90, $this->source); })()), "html");
                                yield "\"/>
                                ";
                            } elseif (((CoreExtension::getAttribute($this->env, $this->source,                             // line 91
$context["action"], "type", [], "any", false, false, false, 91) == "outlink") || (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "type", [], "any", false, false, false, 91) == "download"))) {
                                // line 92
                                yield "                                    <img class='iconPadding' src=\"";
                                yield \Piwik\piwik_escape_filter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", true, true, false, 92)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", false, false, false, 92), CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 92))) : (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 92))), "html", null, true);
                                yield "\"
                                         title=\"";
                                // line 93
                                if (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "url", [], "any", true, true, false, 93)) {
                                    yield \Piwik\piwik_escape_filter($this->env, \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "url", [], "any", false, false, false, 93), "html"), "html");
                                    yield " - ";
                                }
                                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "serverTimePretty", [], "any", false, false, false, 93), "html", null, true);
                                yield "\"/>
                                ";
                            } elseif ((CoreExtension::getAttribute($this->env, $this->source,                             // line 94
$context["action"], "type", [], "any", false, false, false, 94) == "search")) {
                                // line 95
                                yield "                                    <img class='iconPadding' src=\"";
                                yield \Piwik\piwik_escape_filter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", true, true, false, 95)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", false, false, false, 95), CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 95))) : (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 95))), "html", null, true);
                                yield "\"
                                         title=\"";
                                // line 96
                                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Actions_SubmenuSitesearch"), "html", null, true);
                                yield ": ";
                                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('rawSafeDecoded')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "siteSearchKeyword", [], "any", false, false, false, 96)), "html_attr");
                                yield " - ";
                                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "serverTimePretty", [], "any", false, false, false, 96), "html", null, true);
                                yield "\"/>
                                ";
                            } elseif ( !Twig\Extension\CoreExtension::testEmpty(((CoreExtension::getAttribute($this->env, $this->source,                             // line 97
$context["action"], "eventCategory", [], "any", true, true, false, 97)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "eventCategory", [], "any", false, false, false, 97), false)) : (false)))) {
                                // line 98
                                yield "                                    <img  class=\"iconPadding\" src='";
                                yield \Piwik\piwik_escape_filter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", true, true, false, 98)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", false, false, false, 98), CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 98))) : (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 98))), "html", null, true);
                                yield "'
                                        title=\"";
                                // line 99
                                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Events_Event"), "html", null, true);
                                yield " ";
                                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "eventCategory", [], "any", false, false, false, 99), "html", null, true);
                                yield " - ";
                                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "eventAction", [], "any", false, false, false, 99), "html", null, true);
                                yield " ";
                                if (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "eventName", [], "any", true, true, false, 99)) {
                                    yield "- ";
                                    yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "eventName", [], "any", false, false, false, 99), "html", null, true);
                                }
                                yield " ";
                                if (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "eventValue", [], "any", true, true, false, 99)) {
                                    yield "- ";
                                    yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "eventValue", [], "any", false, false, false, 99), "html", null, true);
                                }
                                yield "\"/>
                                ";
                            } elseif ((((CoreExtension::getAttribute($this->env, $this->source,                             // line 100
$context["action"], "type", [], "any", false, false, false, 100) == "goal") || (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "type", [], "any", false, false, false, 100) == Twig\Extension\CoreExtension::constant("Piwik\\Piwik::LABEL_ID_GOAL_IS_ECOMMERCE_ORDER"))) || (CoreExtension::getAttribute($this->env, $this->source,                             // line 101
$context["action"], "type", [], "any", false, false, false, 101) == Twig\Extension\CoreExtension::constant("Piwik\\Piwik::LABEL_ID_GOAL_IS_ECOMMERCE_CART")))) {
                                // line 102
                                yield "                                    <img class='iconPadding' src=\"";
                                yield \Piwik\piwik_escape_filter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", true, true, false, 102)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "iconSVG", [], "any", false, false, false, 102), CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 102))) : (CoreExtension::getAttribute($this->env, $this->source, $context["action"], "icon", [], "any", false, false, false, 102))), "html", null, true);
                                yield "\"
                                         title=\"";
                                // line 103
                                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "goalName", [], "any", false, false, false, 103), "html", null, true);
                                yield " - ";
                                if ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "revenue", [], "any", false, false, false, 103) > 0)) {
                                    yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_ColumnRevenue"), "html", null, true);
                                    yield ": ";
                                    yield $this->env->getFilter('money')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "revenue", [], "any", false, false, false, 103), (isset($context["idSite"]) || array_key_exists("idSite", $context) ? $context["idSite"] : (function () { throw new RuntimeError('Variable "idSite" does not exist.', 103, $this->source); })()));
                                    yield " - ";
                                }
                                yield " ";
                                yield \Piwik\piwik_escape_filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["action"], "serverTimePretty", [], "any", false, false, false, 103), "html", null, true);
                                yield "\"/>
                                ";
                            }
                            // line 105
                            yield "                            ";
                            if ((CoreExtension::getAttribute($this->env, $this->source, $context["action"], "url", [], "any", true, true, false, 105) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["action"], "url", [], "any", false, false, false, 105)))) {
                                // line 106
                                yield "                            </a>
                            ";
                            }
                            // line 108
                            yield "                        ";
                        }
                        // line 109
                        yield "                    ";
                    }
                    // line 110
                    yield "                ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['action'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 111
                yield "
                ";
                // line 112
                if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["visitor"], "getColumn", ["actionDetails"], "method", false, false, false, 112)) > (isset($context["maxPagesDisplayedByVisitor"]) || array_key_exists("maxPagesDisplayedByVisitor", $context) ? $context["maxPagesDisplayedByVisitor"] : (function () { throw new RuntimeError('Variable "maxPagesDisplayedByVisitor" does not exist.', 112, $this->source); })()))) {
                    // line 113
                    yield "                    (";
                    yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Live_MorePagesNotDisplayed"), "html", null, true);
                    yield ")
                ";
                }
                // line 115
                yield "            </div>
        </li>
    ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['visitor'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 118
            yield "</ul>
";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@Live/getLastVisitsStart.twig";
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
        return array (  489 => 118,  473 => 115,  467 => 113,  465 => 112,  462 => 111,  448 => 110,  445 => 109,  442 => 108,  438 => 106,  435 => 105,  421 => 103,  416 => 102,  414 => 101,  413 => 100,  395 => 99,  390 => 98,  388 => 97,  380 => 96,  375 => 95,  373 => 94,  365 => 93,  360 => 92,  358 => 91,  351 => 90,  341 => 88,  337 => 87,  334 => 86,  328 => 85,  325 => 84,  319 => 83,  317 => 82,  314 => 80,  308 => 78,  306 => 77,  303 => 76,  298 => 73,  290 => 71,  288 => 70,  284 => 69,  279 => 68,  275 => 67,  249 => 64,  245 => 63,  243 => 62,  240 => 61,  236 => 60,  233 => 58,  229 => 57,  225 => 55,  223 => 54,  219 => 52,  217 => 51,  214 => 50,  211 => 48,  208 => 46,  206 => 45,  203 => 44,  201 => 43,  198 => 42,  195 => 41,  177 => 40,  175 => 39,  171 => 38,  165 => 37,  160 => 35,  156 => 33,  150 => 30,  139 => 29,  137 => 28,  133 => 26,  131 => 25,  127 => 23,  113 => 19,  111 => 18,  107 => 17,  93 => 15,  91 => 14,  87 => 13,  83 => 12,  78 => 10,  71 => 9,  54 => 8,  51 => 7,  45 => 5,  43 => 4,  40 => 3,  38 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("{# some users view thousands of pages which can crash the browser viewing Live! #}
{% set maxPagesDisplayedByVisitor=100 %}

{% if error is not empty %}
<div vue-entry=\"CoreHome.Alert\" severity=\"danger\">{{ error }}</div>
{% else %}
<ul id=\"visitsLive\">
    {% for visitor in visitors.getRows() %}
        <li id=\"vid{{ visitor.getColumn('idVisit') }}\" class=\"visit\" data-hash=\"{{ visitor|json_encode|md5 }}\">
            <div style=\"display:none;\" class=\"idvisit\">{{ visitor.idVisit }}</div>
            <div class=\"datetime\">
                <span style=\"display:none;\" class=\"serverTimestamp\">{{ visitor.getColumn('serverTimestamp')|raw }}</span>
                {{ postEvent('Live.visitorLogWidgetViewBeforeVisitInfo', visitor) }}
                {% set year = visitor.getColumn('serverTimestamp')|date('Y') %}
                <span class=\"realTimeWidget_datetime\">{{ visitor.getColumn('serverDatePretty')|replace({(year): ' '}) }} - {{ visitor.getColumn('serverTimePretty') }} {% if visitor.getColumn('visitDuration') > 0 %}({{ visitor.getColumn('visitDurationPretty')|raw }}){% endif %}</span>

                {{ postEvent('Live.renderVisitorIcons', visitor) }}
                {% if isProfileEnabled and not userIsAnonymous %}
                    <a class=\"visits-live-launch-visitor-profile rightLink\" title=\"{{ 'Live_ViewVisitorProfile'|translate }} {% if visitor.getColumn('userId') is not empty %}{{ visitor.getColumn('userId') }}{% endif %}\" data-visitor-id=\"{{ visitor.getColumn('visitorId') }}\">
                        <span class=\"icon-visitor-profile\"></span>
                    </a>
                {% endif %}

                <span class=\"referrer\">
                    {% include \"@Referrers/_visitorDetails.twig\" with {'visitInfo': visitor} %}
                 </span>

                {% if visitor.getColumn('userId')|default(false) is not empty %}
                    <a class=\"visits-live-launch-visitor-profile rightLink\" title=\"{{ 'Live_ViewVisitorProfile'|translate }} {% if visitor.getColumn('userId') is not empty %}{{ visitor.getColumn('userId') }}{% endif %}\" data-visitor-id=\"{{ visitor.getColumn('visitorId') }}\">
                        <span>{{ visitor.getColumn('userId')|rawSafeDecoded}}</span>
                    </a>
                {% endif %}

            </div>
            <div id=\"actions_{{ visitor.getColumn('idVisit') }}\" class=\"settings\">
                <span class=\"pagesTitle\"
                      title=\"{{ visitor.getColumn('actionDetails')|length }} {{ 'General_Actions'|translate }}\"
                      >{{ 'General_Actions'|translate }}:</span>&nbsp;
                {% set col = 0 %}
                {% for action in visitor.getColumn('actionDetails') %}
                    {% if loop.index <= maxPagesDisplayedByVisitor %}

                        {% if action.type == 'ecommerceOrder' or action.type == 'ecommerceAbandonedCart' %}
                            {% set title %}
                                {%- if action.type == 'ecommerceOrder' %}
                                    {{- 'Goals_EcommerceOrder'|translate -}}
                                {% else %}
                                    {{- 'Goals_AbandonedCart'|translate -}}
                                {% endif %}
                                {{- \"\\n - \" -}}
                                {%- if action.type == 'ecommerceOrder' -%}
                                    {{- 'General_ColumnRevenue'|translate -}}:
                                  {%- else -%}
                                    {%- set revenueLeft -%}
                                        {{- 'General_ColumnRevenue'|translate -}}
                                    {%- endset -%}
                                    {{- 'Goals_LeftInCart'|translate(revenueLeft) -}}:
                                {%- endif %} {{ action.revenue|money(idSite)|raw -}}

                                {{- \"\\n - \" -}}{{- action.serverTimePretty -}}
                                {{- \"\\n\" -}}
                                {% if action.itemDetails is not empty -%}
                                    {% for product in action.itemDetails -%}
                                        {{- \"\\n# \" -}}{{ product.itemSKU }}{% if product.itemName is not empty %}: {{ product.itemName }}{% endif %}{% if product.itemCategory is not empty %} ({{ product.itemCategory }}){% endif %}, {{ 'General_Quantity'|translate }}: {{ product.quantity }}, {{ 'General_Price'|translate }}: {{ product.price|money(idSite)|raw }}
                                    {%- endfor %}
                                {%- endif %}
                            {% endset %}
                            <span title=\"{{- title|e('html') -}}\">
                                <img class='iconPadding' src=\"{{ action.iconSVG|default(action.icon) }}\"/>
                                {% if action.type == 'ecommerceOrder' %}
                                    {{ 'General_ColumnRevenue'|translate }}: {{ action.revenue|money(idSite)|raw }}
                                {% endif %}
                            </span>

                        {% else %}

                            {% if action.url is defined and action.url is not empty %}
                            <a href=\"{{ action.url|safelink|e('html_attr') }}\" target=\"_blank\" rel=\"noreferrer noopener\">
                            {% endif %}
                                {% if action.type == 'action' %}
{# white spacing matters as Chrome tooltip display whitespaces #}
{% set title %}
{% if action.url|trim is not empty %}<span>{{ action.url }}</span>{% endif %}

{% if action.pageTitle is not empty %}<span>{{ action.pageTitle|rawSafeDecoded }}</span>{% endif %}

<span>{{ action.serverTimePretty }}</span>
    {% if action.timeSpentPretty is defined %}<span>{{ 'General_TimeOnPage'|translate }}: {{ action.timeSpentPretty|raw }}</span>{% endif %}
{%- endset %}
                                    <img class='iconPadding' src=\"{{ action.iconSVG|default(action.icon) }}\" title=\"{{- title|e('html') -}}\"/>
                                {% elseif action.type == 'outlink' or action.type == 'download' %}
                                    <img class='iconPadding' src=\"{{ action.iconSVG|default(action.icon) }}\"
                                         title=\"{% if action.url is defined %}{{ action.url|e('html')|e('html') }} - {% endif %}{{ action.serverTimePretty }}\"/>
                                {% elseif action.type == 'search' %}
                                    <img class='iconPadding' src=\"{{ action.iconSVG|default(action.icon) }}\"
                                         title=\"{{ 'Actions_SubmenuSitesearch'|translate }}: {{ action.siteSearchKeyword|rawSafeDecoded|e('html_attr') }} - {{ action.serverTimePretty }}\"/>
                                {% elseif action.eventCategory|default(false) is not empty %}
                                    <img  class=\"iconPadding\" src='{{ action.iconSVG|default(action.icon) }}'
                                        title=\"{{ 'Events_Event'|translate }} {{ action.eventCategory }} - {{ action.eventAction }} {% if action.eventName is defined %}- {{ action.eventName }}{% endif %} {% if action.eventValue is defined %}- {{ action.eventValue }}{% endif %}\"/>
                                {% elseif action.type == 'goal' or action.type == constant('Piwik\\\\Piwik::LABEL_ID_GOAL_IS_ECOMMERCE_ORDER') or
                                          action.type == constant('Piwik\\\\Piwik::LABEL_ID_GOAL_IS_ECOMMERCE_CART') %}
                                    <img class='iconPadding' src=\"{{ action.iconSVG|default(action.icon) }}\"
                                         title=\"{{ action.goalName }} - {% if action.revenue > 0 %}{{ 'General_ColumnRevenue'|translate }}: {{ action.revenue|money(idSite)|raw }} - {% endif %} {{ action.serverTimePretty }}\"/>
                                {% endif %}
                            {% if action.url is defined and action.url is not empty %}
                            </a>
                            {% endif %}
                        {% endif %}
                    {% endif %}
                {% endfor %}

                {% if visitor.getColumn('actionDetails')|length > maxPagesDisplayedByVisitor %}
                    ({{ 'Live_MorePagesNotDisplayed'|translate }})
                {% endif %}
            </div>
        </li>
    {% endfor %}
</ul>
{% endif %}
", "@Live/getLastVisitsStart.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Live/templates/getLastVisitsStart.twig");
    }
}
