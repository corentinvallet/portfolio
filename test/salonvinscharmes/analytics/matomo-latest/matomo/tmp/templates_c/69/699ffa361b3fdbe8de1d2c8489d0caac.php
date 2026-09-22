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

/* @CoreVisualizations/_dataTableViz_sparklines.twig */
class __TwigTemplate_57bd1a9bafd0cf31d9e867f49d7dc90c extends Template
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
        $macros["macros"] = $this->macros["macros"] = $this->loadTemplate("@CoreVisualizations/macros.twig", "@CoreVisualizations/_dataTableViz_sparklines.twig", 1)->unwrap();
        // line 2
        yield "
";
        // line 3
        if ( !(isset($context["isWidget"]) || array_key_exists("isWidget", $context) ? $context["isWidget"] : (function () { throw new RuntimeError('Variable "isWidget" does not exist.', 3, $this->source); })())) {
            // line 4
            yield "    <div class=\"card\"><div class=\"card-content\">
";
        }
        // line 6
        yield "    ";
        if ( !Twig\Extension\CoreExtension::testEmpty((isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 6, $this->source); })()))) {
            yield "<h2 class=\"card-title\"
                                    ";
            // line 7
            if ( !Twig\Extension\CoreExtension::testEmpty((isset($context["titleAttributes"]) || array_key_exists("titleAttributes", $context) ? $context["titleAttributes"] : (function () { throw new RuntimeError('Variable "titleAttributes" does not exist.', 7, $this->source); })()))) {
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable((isset($context["titleAttributes"]) || array_key_exists("titleAttributes", $context) ? $context["titleAttributes"] : (function () { throw new RuntimeError('Variable "titleAttributes" does not exist.', 7, $this->source); })()));
                foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                    yield \Piwik\piwik_escape_filter($this->env, $context["attribute"], "html", null, true);
                    yield "=\"";
                    yield \Piwik\piwik_escape_filter($this->env, $context["value"], "html", null, true);
                    yield "\"";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            // line 8
            yield "                                >";
            yield \Piwik\piwik_escape_filter($this->env, (isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 8, $this->source); })()), "html", null, true);
            yield "</h2>";
        }
        // line 9
        yield "    ";
        if ((isset($context["useNewSparklinesGrid"]) || array_key_exists("useNewSparklinesGrid", $context) ? $context["useNewSparklinesGrid"] : (function () { throw new RuntimeError('Variable "useNewSparklinesGrid" does not exist.', 9, $this->source); })())) {
            // line 10
            yield "    <div vue-entry=\"CoreVisualizations.SparklinesGrid\"
         sparklines=\"";
            // line 11
            yield \Piwik\piwik_escape_filter($this->env, json_encode((isset($context["sparklines"]) || array_key_exists("sparklines", $context) ? $context["sparklines"] : (function () { throw new RuntimeError('Variable "sparklines" does not exist.', 11, $this->source); })())), "html_attr");
            yield "\"
         all-metrics-documentation=\"";
            // line 12
            yield \Piwik\piwik_escape_filter($this->env, json_encode((isset($context["allMetricsDocumentation"]) || array_key_exists("allMetricsDocumentation", $context) ? $context["allMetricsDocumentation"] : (function () { throw new RuntimeError('Variable "allMetricsDocumentation" does not exist.', 12, $this->source); })())), "html_attr");
            yield "\"
         are-sparklines-linkable=\"";
            // line 13
            yield \Piwik\piwik_escape_filter($this->env, json_encode((isset($context["areSparklinesLinkable"]) || array_key_exists("areSparklinesLinkable", $context) ? $context["areSparklinesLinkable"] : (function () { throw new RuntimeError('Variable "areSparklinesLinkable" does not exist.', 13, $this->source); })())), "html_attr");
            yield "\"
         comparison-mode=\"";
            // line 14
            yield \Piwik\piwik_escape_filter($this->env, json_encode((isset($context["sparklinesComparisonMode"]) || array_key_exists("sparklinesComparisonMode", $context) ? $context["sparklinesComparisonMode"] : (function () { throw new RuntimeError('Variable "sparklinesComparisonMode" does not exist.', 14, $this->source); })())), "html_attr");
            yield "\"
         is-widget=\"";
            // line 15
            yield \Piwik\piwik_escape_filter($this->env, json_encode(((isset($context["isWidget"]) || array_key_exists("isWidget", $context) ? $context["isWidget"] : (function () { throw new RuntimeError('Variable "isWidget" does not exist.', 15, $this->source); })()) == 1)), "html_attr");
            yield "\"></div>
    ";
        } else {
            // line 17
            yield "    ";
            if ( !(isset($context["isWidget"]) || array_key_exists("isWidget", $context) ? $context["isWidget"] : (function () { throw new RuntimeError('Variable "isWidget" does not exist.', 17, $this->source); })())) {
                // line 18
                yield "    <div class=\"row\">
        <div class=\"col m6\">
    ";
            }
            // line 21
            yield "            ";
            if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["sparklines"]) || array_key_exists("sparklines", $context) ? $context["sparklines"] : (function () { throw new RuntimeError('Variable "sparklines" does not exist.', 21, $this->source); })())) == 1)) {
                // line 22
                yield "            ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::first($this->env->getCharset(), (isset($context["sparklines"]) || array_key_exists("sparklines", $context) ? $context["sparklines"] : (function () { throw new RuntimeError('Variable "sparklines" does not exist.', 22, $this->source); })())));
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
                foreach ($context['_seq'] as $context["key"] => $context["sparkline"]) {
                    // line 23
                    yield "                ";
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 23) % 2 == 0)) {
                        // line 24
                        yield "                    ";
                        yield CoreExtension::callMacro($macros["macros"], "macro_singleSparkline", [$context["sparkline"], (isset($context["allMetricsDocumentation"]) || array_key_exists("allMetricsDocumentation", $context) ? $context["allMetricsDocumentation"] : (function () { throw new RuntimeError('Variable "allMetricsDocumentation" does not exist.', 24, $this->source); })()), (isset($context["areSparklinesLinkable"]) || array_key_exists("areSparklinesLinkable", $context) ? $context["areSparklinesLinkable"] : (function () { throw new RuntimeError('Variable "areSparklinesLinkable" does not exist.', 24, $this->source); })())], 24, $context, $this->getSourceContext());
                        yield "
                ";
                    }
                    // line 26
                    yield "            ";
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
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['sparkline'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 27
                yield "            ";
            } else {
                // line 28
                yield "                ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable((isset($context["sparklines"]) || array_key_exists("sparklines", $context) ? $context["sparklines"] : (function () { throw new RuntimeError('Variable "sparklines" does not exist.', 28, $this->source); })()));
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
                foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
                    // line 29
                    yield "                    ";
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 29) % 2 == 0)) {
                        // line 30
                        yield "                        <div>
                            ";
                        // line 31
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable($context["group"]);
                        foreach ($context['_seq'] as $context["key"] => $context["sparkline"]) {
                            // line 32
                            yield "                                ";
                            yield CoreExtension::callMacro($macros["macros"], "macro_singleSparkline", [$context["sparkline"], (isset($context["allMetricsDocumentation"]) || array_key_exists("allMetricsDocumentation", $context) ? $context["allMetricsDocumentation"] : (function () { throw new RuntimeError('Variable "allMetricsDocumentation" does not exist.', 32, $this->source); })()), (isset($context["areSparklinesLinkable"]) || array_key_exists("areSparklinesLinkable", $context) ? $context["areSparklinesLinkable"] : (function () { throw new RuntimeError('Variable "areSparklinesLinkable" does not exist.', 32, $this->source); })())], 32, $context, $this->getSourceContext());
                            yield "
                            ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['key'], $context['sparkline'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 34
                        yield "                        </div>
                    ";
                    }
                    // line 36
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
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 37
                yield "            ";
            }
            // line 38
            yield "
    ";
            // line 39
            if ( !(isset($context["isWidget"]) || array_key_exists("isWidget", $context) ? $context["isWidget"] : (function () { throw new RuntimeError('Variable "isWidget" does not exist.', 39, $this->source); })())) {
                // line 40
                yield "            <br style=\"clear:left\"/>
        </div>
        <div class=\"col m6\">
    ";
            }
            // line 44
            yield "
            ";
            // line 45
            if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["sparklines"]) || array_key_exists("sparklines", $context) ? $context["sparklines"] : (function () { throw new RuntimeError('Variable "sparklines" does not exist.', 45, $this->source); })())) == 1)) {
                // line 46
                yield "            ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable((isset($context["sparklines"]) || array_key_exists("sparklines", $context) ? $context["sparklines"] : (function () { throw new RuntimeError('Variable "sparklines" does not exist.', 46, $this->source); })()));
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
                foreach ($context['_seq'] as $context["key"] => $context["sparkline"]) {
                    // line 47
                    yield "                ";
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 47) % 2 != 0)) {
                        // line 48
                        yield "                    ";
                        yield CoreExtension::callMacro($macros["macros"], "macro_singleSparkline", [$context["sparkline"], (isset($context["allMetricsDocumentation"]) || array_key_exists("allMetricsDocumentation", $context) ? $context["allMetricsDocumentation"] : (function () { throw new RuntimeError('Variable "allMetricsDocumentation" does not exist.', 48, $this->source); })()), (isset($context["areSparklinesLinkable"]) || array_key_exists("areSparklinesLinkable", $context) ? $context["areSparklinesLinkable"] : (function () { throw new RuntimeError('Variable "areSparklinesLinkable" does not exist.', 48, $this->source); })())], 48, $context, $this->getSourceContext());
                        yield "
                ";
                    }
                    // line 50
                    yield "            ";
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
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['sparkline'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 51
                yield "            ";
            } else {
                // line 52
                yield "                ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable((isset($context["sparklines"]) || array_key_exists("sparklines", $context) ? $context["sparklines"] : (function () { throw new RuntimeError('Variable "sparklines" does not exist.', 52, $this->source); })()));
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
                foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
                    // line 53
                    yield "                    ";
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 53) % 2 != 0)) {
                        // line 54
                        yield "                        <div>
                            ";
                        // line 55
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable($context["group"]);
                        foreach ($context['_seq'] as $context["key"] => $context["sparkline"]) {
                            // line 56
                            yield "                                ";
                            yield CoreExtension::callMacro($macros["macros"], "macro_singleSparkline", [$context["sparkline"], (isset($context["allMetricsDocumentation"]) || array_key_exists("allMetricsDocumentation", $context) ? $context["allMetricsDocumentation"] : (function () { throw new RuntimeError('Variable "allMetricsDocumentation" does not exist.', 56, $this->source); })()), (isset($context["areSparklinesLinkable"]) || array_key_exists("areSparklinesLinkable", $context) ? $context["areSparklinesLinkable"] : (function () { throw new RuntimeError('Variable "areSparklinesLinkable" does not exist.', 56, $this->source); })())], 56, $context, $this->getSourceContext());
                            yield "
                            ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['key'], $context['sparkline'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 58
                        yield "                        </div>
                    ";
                    }
                    // line 60
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
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 61
                yield "            ";
            }
            // line 62
            yield "
            <br style=\"clear:left\"/>

    ";
            // line 65
            if ( !(isset($context["isWidget"]) || array_key_exists("isWidget", $context) ? $context["isWidget"] : (function () { throw new RuntimeError('Variable "isWidget" does not exist.', 65, $this->source); })())) {
                // line 66
                yield "        </div>
    </div>
    ";
            }
            // line 69
            yield "    ";
        }
        // line 70
        yield "
    ";
        // line 71
        if ((isset($context["areSparklinesLinkable"]) || array_key_exists("areSparklinesLinkable", $context) ? $context["areSparklinesLinkable"] : (function () { throw new RuntimeError('Variable "areSparklinesLinkable" does not exist.', 71, $this->source); })())) {
            // line 72
            yield "        ";
            yield from             $this->loadTemplate("_sparklineFooter.twig", "@CoreVisualizations/_dataTableViz_sparklines.twig", 72)->unwrap()->yield($context);
            // line 73
            yield "    ";
        }
        // line 74
        yield "
    ";
        // line 75
        if ( !Twig\Extension\CoreExtension::testEmpty((isset($context["footerMessage"]) || array_key_exists("footerMessage", $context) ? $context["footerMessage"] : (function () { throw new RuntimeError('Variable "footerMessage" does not exist.', 75, $this->source); })()))) {
            // line 76
            yield "        <div class='datatableFooterMessage'>";
            yield (isset($context["footerMessage"]) || array_key_exists("footerMessage", $context) ? $context["footerMessage"] : (function () { throw new RuntimeError('Variable "footerMessage" does not exist.', 76, $this->source); })());
            yield "</div>
    ";
        }
        // line 78
        if ( !(isset($context["isWidget"]) || array_key_exists("isWidget", $context) ? $context["isWidget"] : (function () { throw new RuntimeError('Variable "isWidget" does not exist.', 78, $this->source); })())) {
            // line 79
            yield "        </div></div>
";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@CoreVisualizations/_dataTableViz_sparklines.twig";
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
        return array (  370 => 79,  368 => 78,  362 => 76,  360 => 75,  357 => 74,  354 => 73,  351 => 72,  349 => 71,  346 => 70,  343 => 69,  338 => 66,  336 => 65,  331 => 62,  328 => 61,  314 => 60,  310 => 58,  301 => 56,  297 => 55,  294 => 54,  291 => 53,  273 => 52,  270 => 51,  256 => 50,  250 => 48,  247 => 47,  229 => 46,  227 => 45,  224 => 44,  218 => 40,  216 => 39,  213 => 38,  210 => 37,  196 => 36,  192 => 34,  183 => 32,  179 => 31,  176 => 30,  173 => 29,  155 => 28,  152 => 27,  138 => 26,  132 => 24,  129 => 23,  111 => 22,  108 => 21,  103 => 18,  100 => 17,  95 => 15,  91 => 14,  87 => 13,  83 => 12,  79 => 11,  76 => 10,  73 => 9,  68 => 8,  54 => 7,  49 => 6,  45 => 4,  43 => 3,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% import '@CoreVisualizations/macros.twig' as macros %}

{% if not isWidget %}
    <div class=\"card\"><div class=\"card-content\">
{% endif %}
    {% if title is not empty %}<h2 class=\"card-title\"
                                    {% if titleAttributes is not empty %}{% for attribute, value in titleAttributes %}{{ attribute }}=\"{{ value }}\"{% endfor %}{% endif %}
                                >{{ title }}</h2>{% endif %}
    {% if useNewSparklinesGrid %}
    <div vue-entry=\"CoreVisualizations.SparklinesGrid\"
         sparklines=\"{{ sparklines|json_encode|e('html_attr') }}\"
         all-metrics-documentation=\"{{ allMetricsDocumentation|json_encode|e('html_attr') }}\"
         are-sparklines-linkable=\"{{ areSparklinesLinkable|json_encode|e('html_attr') }}\"
         comparison-mode=\"{{ sparklinesComparisonMode|json_encode|e('html_attr') }}\"
         is-widget=\"{{ (isWidget == 1)|json_encode|e('html_attr') }}\"></div>
    {% else %}
    {% if not isWidget %}
    <div class=\"row\">
        <div class=\"col m6\">
    {% endif %}
            {% if sparklines|length == 1 %}
            {% for key, sparkline in sparklines|first %}
                {% if loop.index0 is even %}
                    {{ macros.singleSparkline(sparkline, allMetricsDocumentation, areSparklinesLinkable) }}
                {% endif %}
            {% endfor %}
            {% else %}
                {% for group in sparklines %}
                    {% if loop.index0 is even %}
                        <div>
                            {% for key, sparkline in group %}
                                {{ macros.singleSparkline(sparkline, allMetricsDocumentation, areSparklinesLinkable) }}
                            {% endfor %}
                        </div>
                    {% endif %}
                {% endfor %}
            {% endif %}

    {% if not isWidget %}
            <br style=\"clear:left\"/>
        </div>
        <div class=\"col m6\">
    {% endif %}

            {% if sparklines|length == 1 %}
            {% for key, sparkline in sparklines %}
                {% if loop.index0 is odd %}
                    {{ macros.singleSparkline(sparkline, allMetricsDocumentation, areSparklinesLinkable) }}
                {% endif %}
            {% endfor %}
            {% else %}
                {% for group in sparklines %}
                    {% if loop.index0 is odd %}
                        <div>
                            {% for key, sparkline in group %}
                                {{ macros.singleSparkline(sparkline, allMetricsDocumentation, areSparklinesLinkable) }}
                            {% endfor %}
                        </div>
                    {% endif %}
                {% endfor %}
            {% endif %}

            <br style=\"clear:left\"/>

    {% if not isWidget %}
        </div>
    </div>
    {% endif %}
    {% endif %}

    {%  if areSparklinesLinkable %}
        {% include \"_sparklineFooter.twig\" %}
    {% endif %}

    {% if footerMessage is not empty %}
        <div class='datatableFooterMessage'>{{ footerMessage | raw }}</div>
    {% endif %}
{% if not isWidget %}
        </div></div>
{% endif %}
", "@CoreVisualizations/_dataTableViz_sparklines.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/CoreVisualizations/templates/_dataTableViz_sparklines.twig");
    }
}
