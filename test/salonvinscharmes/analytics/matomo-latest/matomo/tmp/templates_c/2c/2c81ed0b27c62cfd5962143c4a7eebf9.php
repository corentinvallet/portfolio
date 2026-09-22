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

/* @SegmentEditor/_segmentSelector.twig */
class __TwigTemplate_346d12b9f349e8f6531e685314a06b7c extends Template
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
        yield "<div class=\"SegmentEditor\" style=\"display:none;\">
    <div class=\"segmentationContainer listHtml\">
        <a class=\"title\" tabindex=\"4\" title=\"";
        // line 3
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_ChooseASegment"), "html", null, true);
        yield ". ";
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_CurrentlySelectedSegment", (isset($context["segmentDescription"]) || array_key_exists("segmentDescription", $context) ? $context["segmentDescription"] : (function () { throw new RuntimeError('Variable "segmentDescription" does not exist.', 3, $this->source); })())), "html", null, true);
        yield "\">
            <span class=\"icon icon-segment\"></span><span class=\"segmentationTitle\"></span>
        </a>
        <div class=\"dropdown dropdown-body\">
            <div class=\"segmentFilterContainer\">
                <input class=\"segmentFilter browser-default\" type=\"text\" tabindex=\"4\" value=\"\" placeholder=\"";
        // line 8
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Search"), "html", null, true);
        yield "\"/>
                <span></span>
            </div>
            <ul class=\"submenu\">
                <li>";
        // line 12
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_SelectSegmentOfVisits"), "html", null, true);
        yield "
                    <div class=\"segmentList\">
                        <ul>
                        </ul>
                    </div>
                </li>
            </ul>

            ";
        // line 20
        if ((isset($context["authorizedToCreateSegments"]) || array_key_exists("authorizedToCreateSegments", $context) ? $context["authorizedToCreateSegments"] : (function () { throw new RuntimeError('Variable "authorizedToCreateSegments" does not exist.', 20, $this->source); })())) {
            // line 21
            yield "                <button tabindex=\"4\" class=\"add_new_segment btn\">
                    <span class=\"icon-add\"></span>&nbsp;
                    ";
            // line 23
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_AddNewSegment"), "html", null, true);
            yield "
                </button>
                <a href=\"index.php?";
            // line 25
            yield \Piwik\piwik_escape_filter($this->env, Twig\Extension\CoreExtension::slice($this->env->getCharset(), $this->env->getFilter('urlRewriteWithParameters')->getCallable()((isset($context["manageSegmentUrl"]) || array_key_exists("manageSegmentUrl", $context) ? $context["manageSegmentUrl"] : (function () { throw new RuntimeError('Variable "manageSegmentUrl" does not exist.', 25, $this->source); })())), 1), "html", null, true);
            yield "\" tabindex=\"4\" class=\"btn btn-block btn-outline\">
                    ";
            // line 26
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_ManageSegments"), "html", null, true);
            yield "
                </a>
            ";
        } else {
            // line 29
            yield "                <hr/>
                <ul class=\"submenu\">
                <li>
                    ";
            // line 32
            if ((isset($context["isUserAnonymous"]) || array_key_exists("isUserAnonymous", $context) ? $context["isUserAnonymous"] : (function () { throw new RuntimeError('Variable "isUserAnonymous" does not exist.', 32, $this->source); })())) {
                // line 33
                yield "                        <span class='youMustBeLoggedIn'>";
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_YouMustBeLoggedInToCreateSegments"), "html", null, true);
                yield "
                        <br/>&rsaquo; <a href='index.php?module=";
                // line 34
                yield \Piwik\piwik_escape_filter($this->env, (isset($context["loginModule"]) || array_key_exists("loginModule", $context) ? $context["loginModule"] : (function () { throw new RuntimeError('Variable "loginModule" does not exist.', 34, $this->source); })()), "html", null, true);
                yield "'>";
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_LogIn"), "html", null, true);
                yield "</a> </span>
                    ";
            }
            // line 36
            yield "                </li>
                </ul>
                <br/><br/>
            ";
        }
        // line 40
        yield "        </div>
    </div>

    <div class=\"segment-element borderedControl expanded\">

        <div class=\"segment-content\">
            <div class=\"segment-top\" ";
        // line 46
        if ( !(isset($context["isSuperUser"]) || array_key_exists("isSuperUser", $context) ? $context["isSuperUser"] : (function () { throw new RuntimeError('Variable "isSuperUser" does not exist.', 46, $this->source); })())) {
            yield "style=\"display:none\"";
        }
        yield ">
               <input type=\"hidden\" class=\"available_segments_select\"/>
               <div class=\"segment-top-item grid-1\">
                ";
        // line 49
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_ThisSegmentIsVisibleTo"), "html", null, true);
        yield " <div class=\"enable_all_users\"><strong>
                        <select class=\"enable_all_users_select\">
                            <option ";
        // line 51
        if ( !(isset($context["isSuperUser"]) || array_key_exists("isSuperUser", $context) ? $context["isSuperUser"] : (function () { throw new RuntimeError('Variable "isSuperUser" does not exist.', 51, $this->source); })())) {
            yield "selected=\"1\"";
        }
        yield " value=\"0\">";
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_VisibleToMe"), "html", null, true);
        yield "</option>
                            <option ";
        // line 52
        if ((isset($context["isSuperUser"]) || array_key_exists("isSuperUser", $context) ? $context["isSuperUser"] : (function () { throw new RuntimeError('Variable "isSuperUser" does not exist.', 52, $this->source); })())) {
            yield "selected=\"1\"";
        }
        yield " value=\"1\">";
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_VisibleToAllUsers"), "html", null, true);
        yield "</option>
                        </select>
                    </strong></div>
                </div>
                <div class=\"segment-top-item grid-2\">
                ";
        // line 57
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_SegmentIsDisplayedForWebsite"), "html", null, true);
        yield "<div class=\"visible_to_website\"><strong>
                        <select class=\"visible_to_website_select\">
                            <option selected=\"\" value=\"";
        // line 59
        yield \Piwik\piwik_escape_filter($this->env, (isset($context["idSite"]) || array_key_exists("idSite", $context) ? $context["idSite"] : (function () { throw new RuntimeError('Variable "idSite" does not exist.', 59, $this->source); })()), "html", null, true);
        yield "\">";
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_SegmentDisplayedThisWebsiteOnly"), "html", null, true);
        yield "</option>
                            ";
        // line 60
        if ((isset($context["isAddingSegmentsForAllWebsitesEnabled"]) || array_key_exists("isAddingSegmentsForAllWebsitesEnabled", $context) ? $context["isAddingSegmentsForAllWebsitesEnabled"] : (function () { throw new RuntimeError('Variable "isAddingSegmentsForAllWebsitesEnabled" does not exist.', 60, $this->source); })())) {
            yield "<option value=\"0\">";
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_SegmentDisplayedAllWebsites"), "html", null, true);
            yield "</option>";
        }
        // line 61
        yield "                        </select>
                    </strong></div>
                </div>
                ";
        // line 64
        if ((isset($context["isCreateRealtimeSegmentsEnabled"]) || array_key_exists("isCreateRealtimeSegmentsEnabled", $context) ? $context["isCreateRealtimeSegmentsEnabled"] : (function () { throw new RuntimeError('Variable "isCreateRealtimeSegmentsEnabled" does not exist.', 64, $this->source); })())) {
            // line 65
            yield "                   <div class=\"segment-top-item grid-3\">
                    ";
            // line 66
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_And"), "html", null, true);
            yield "
                    <div class=\"auto_archive\"><strong>
                            <select class=\"auto_archive_select\">
                                ";
            // line 69
            if ((isset($context["createRealTimeSegmentsIsEnabled"]) || array_key_exists("createRealTimeSegmentsIsEnabled", $context) ? $context["createRealTimeSegmentsIsEnabled"] : (function () { throw new RuntimeError('Variable "createRealTimeSegmentsIsEnabled" does not exist.', 69, $this->source); })())) {
                // line 70
                yield "                                    <option ";
                if ((isset($context["isBrowserArchivingEnabled"]) || array_key_exists("isBrowserArchivingEnabled", $context) ? $context["isBrowserArchivingEnabled"] : (function () { throw new RuntimeError('Variable "isBrowserArchivingEnabled" does not exist.', 70, $this->source); })())) {
                    yield "selected=\"1\"";
                }
                yield " value=\"0\">";
                yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_AutoArchiveRealTime"), "html", null, true);
                yield "</option>
                                ";
            }
            // line 72
            yield "                                <option ";
            if (( !(isset($context["isBrowserArchivingEnabled"]) || array_key_exists("isBrowserArchivingEnabled", $context) ? $context["isBrowserArchivingEnabled"] : (function () { throw new RuntimeError('Variable "isBrowserArchivingEnabled" does not exist.', 72, $this->source); })()) ||  !(isset($context["createRealTimeSegmentsIsEnabled"]) || array_key_exists("createRealTimeSegmentsIsEnabled", $context) ? $context["createRealTimeSegmentsIsEnabled"] : (function () { throw new RuntimeError('Variable "createRealTimeSegmentsIsEnabled" does not exist.', 72, $this->source); })()))) {
                yield "selected=\"1\"";
            }
            yield " value=\"1\">";
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_AutoArchivePreProcessed"), "html", null, true);
            yield " </option>
                            </select>
                        </strong>
                    </div>
                   </div>
                ";
        }
        // line 78
        yield "
            </div>
            <h3 style=\"margin: 12px 6px;\">";
        // line 80
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Name"), "html", null, true);
        yield ": <span  class=\"segmentName\"></span> <a class=\"editSegmentName\" href=\"#\">";
        yield \Piwik\piwik_escape_filter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), $this->env->getFilter('translate')->getCallable()("General_Edit")), "html", null, true);
        yield "</a></h3>
        </div>
        <div class=\"segment-footer\">
            <div vue-entry=\"Feedback.RateFeature\" title=\"&quot;";
        // line 83
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_SegmentEditor"), "html", null, true);
        yield "&quot;\" style=\"display:inline-block;float: left;margin-top: 2px;margin-right: 10px;\"></div>
            <a class=\"btn-flat delete\" href=\"#\">";
        // line 84
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Delete"), "html", null, true);
        yield "</a>
            <a class=\"btn-flat close\" href=\"#\">";
        // line 85
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Close"), "html", null, true);
        yield "</a>
            ";
        // line 86
        if ((isset($context["isVisitorLogEnabled"]) || array_key_exists("isVisitorLogEnabled", $context) ? $context["isVisitorLogEnabled"] : (function () { throw new RuntimeError('Variable "isVisitorLogEnabled" does not exist.', 86, $this->source); })())) {
            // line 87
            yield "                <a class=\"btn-flat testSegment\">";
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_Test"), "html", null, true);
            yield "</a>
            ";
        }
        // line 89
        yield "            <button class=\"btn saveAndApply\">";
        yield $this->env->getFilter('translate')->getCallable()("SegmentEditor_SaveAndApply");
        yield "</button>
        </div>
    </div>
</div>
<div class=\"segmentListContainer\">
<div
    vue-entry=\"SegmentEditor.SegmentSelector\"
    manage-segments-url=\"index.php?";
        // line 96
        yield \Piwik\piwik_escape_filter($this->env, Twig\Extension\CoreExtension::slice($this->env->getCharset(), $this->env->getFilter('urlRewriteWithParameters')->getCallable()((isset($context["manageSegmentUrl"]) || array_key_exists("manageSegmentUrl", $context) ? $context["manageSegmentUrl"] : (function () { throw new RuntimeError('Variable "manageSegmentUrl" does not exist.', 96, $this->source); })())), 1), "html", null, true);
        yield "\"
    is-user-anonymous=\"";
        // line 97
        yield \Piwik\piwik_escape_filter($this->env, json_encode((isset($context["isUserAnonymous"]) || array_key_exists("isUserAnonymous", $context) ? $context["isUserAnonymous"] : (function () { throw new RuntimeError('Variable "isUserAnonymous" does not exist.', 97, $this->source); })())), "html_attr");
        yield "\"
    login-url=\"index.php?module=";
        // line 98
        yield \Piwik\piwik_escape_filter($this->env, (isset($context["loginModule"]) || array_key_exists("loginModule", $context) ? $context["loginModule"] : (function () { throw new RuntimeError('Variable "loginModule" does not exist.', 98, $this->source); })()), "html_attr");
        yield "\"
></div>
<div class=\"ui-confirm\" id=\"segment-delete-confirm\">
    <h2>";
        // line 101
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_AreYouSureDeleteSegment"), "html", null, true);
        yield "</h2>
    <input role=\"yes\" type=\"button\" value=\"";
        // line 102
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Yes"), "html", null, true);
        yield "\"/>
    <input role=\"no\" type=\"button\" value=\"";
        // line 103
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_No"), "html", null, true);
        yield "\"/>
</div>
<div class=\"ui-confirm segment-definition-change-confirm\" data-segment-processed-on-request=\"";
        // line 105
        yield \Piwik\piwik_escape_filter($this->env, $this->extensions['Twig\Extension\CoreExtension']->formatNumber((isset($context["segmentProcessedOnRequest"]) || array_key_exists("segmentProcessedOnRequest", $context) ? $context["segmentProcessedOnRequest"] : (function () { throw new RuntimeError('Variable "segmentProcessedOnRequest" does not exist.', 105, $this->source); })())), "html", null, true);
        yield "\" data-hide-message=\"";
        yield \Piwik\piwik_escape_filter($this->env, (isset($context["hideSegmentDefinitionChangeMessage"]) || array_key_exists("hideSegmentDefinitionChangeMessage", $context) ? $context["hideSegmentDefinitionChangeMessage"] : (function () { throw new RuntimeError('Variable "hideSegmentDefinitionChangeMessage" does not exist.', 105, $this->source); })()), "html", null, true);
        yield "\">
    <h2>
        <span class=\"process-on-request\">
            ";
        // line 108
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_ChangingSegmentDefinitionConfirmationProcessedOnRequest"), "html", null, true);
        yield "
        </span>
        <span class=\"no-process-on-request\">
            ";
        // line 111
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_ChangingSegmentDefinitionConfirmationNotProcessedOnRequest"), "html", null, true);
        yield "
        </span>
    </h2>
    <p class=\"description\">
        <span>
            <label>
                <input type=\"checkbox\" id=\"hideSegmentMessage\" name=\"hideSegmentMessage\" />
                <span>";
        // line 118
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_HideMessageInFuture"), "html", null, true);
        yield "</span>
            </label>
        </span>
    </p>
    <input role=\"yes\" type=\"button\" value=\"";
        // line 122
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Yes"), "html", null, true);
        yield "\"/>
    <input role=\"no\" type=\"button\" value=\"";
        // line 123
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_No"), "html", null, true);
        yield "\"/>
</div>
<div class=\"ui-confirm pleaseChangeBrowserAchivingDisabledSetting\">
    <h2>";
        // line 126
        yield $this->env->getFilter('rawSafeDecoded')->getCallable()($this->env->getFilter('translate')->getCallable()("SegmentEditor_SegmentNotApplied", (isset($context["nameOfCurrentSegment"]) || array_key_exists("nameOfCurrentSegment", $context) ? $context["nameOfCurrentSegment"] : (function () { throw new RuntimeError('Variable "nameOfCurrentSegment" does not exist.', 126, $this->source); })())));
        yield "</h2>
    ";
        // line 127
        $context["segmentSetting"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_AutoArchivePreProcessed"), "html", null, true);
            return; yield '';
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 128
        yield "    <p class=\"description\">
        ";
        // line 129
        yield $this->env->getFilter('rawSafeDecoded')->getCallable()($this->env->getFilter('translate')->getCallable()("SegmentEditor_SegmentNotAppliedMessage", (isset($context["nameOfCurrentSegment"]) || array_key_exists("nameOfCurrentSegment", $context) ? $context["nameOfCurrentSegment"] : (function () { throw new RuntimeError('Variable "nameOfCurrentSegment" does not exist.', 129, $this->source); })())));
        yield "
        <br/>
        ";
        // line 131
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_DataAvailableAtLaterDate"), "html", null, true);
        yield "
        ";
        // line 132
        if ((isset($context["isSuperUser"]) || array_key_exists("isSuperUser", $context) ? $context["isSuperUser"] : (function () { throw new RuntimeError('Variable "isSuperUser" does not exist.', 132, $this->source); })())) {
            // line 133
            yield "            <br/> <br/> ";
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("SegmentEditor_YouMayChangeSetting", "browser_archiving_disabled_enforce", (isset($context["segmentSetting"]) || array_key_exists("segmentSetting", $context) ? $context["segmentSetting"] : (function () { throw new RuntimeError('Variable "segmentSetting" does not exist.', 133, $this->source); })())), "html", null, true);
            yield "
        ";
        }
        // line 135
        yield "    </p>

    <input role=\"yes\" type=\"button\" value=\"";
        // line 137
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Ok"), "html", null, true);
        yield "\"/>
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
        return "@SegmentEditor/_segmentSelector.twig";
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
        return array (  360 => 137,  356 => 135,  350 => 133,  348 => 132,  344 => 131,  339 => 129,  336 => 128,  331 => 127,  327 => 126,  321 => 123,  317 => 122,  310 => 118,  300 => 111,  294 => 108,  286 => 105,  281 => 103,  277 => 102,  273 => 101,  267 => 98,  263 => 97,  259 => 96,  248 => 89,  242 => 87,  240 => 86,  236 => 85,  232 => 84,  228 => 83,  220 => 80,  216 => 78,  202 => 72,  192 => 70,  190 => 69,  184 => 66,  181 => 65,  179 => 64,  174 => 61,  168 => 60,  162 => 59,  157 => 57,  145 => 52,  137 => 51,  132 => 49,  124 => 46,  116 => 40,  110 => 36,  103 => 34,  98 => 33,  96 => 32,  91 => 29,  85 => 26,  81 => 25,  76 => 23,  72 => 21,  70 => 20,  59 => 12,  52 => 8,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"SegmentEditor\" style=\"display:none;\">
    <div class=\"segmentationContainer listHtml\">
        <a class=\"title\" tabindex=\"4\" title=\"{{ 'SegmentEditor_ChooseASegment'|translate }}. {{ 'SegmentEditor_CurrentlySelectedSegment'|translate(segmentDescription) }}\">
            <span class=\"icon icon-segment\"></span><span class=\"segmentationTitle\"></span>
        </a>
        <div class=\"dropdown dropdown-body\">
            <div class=\"segmentFilterContainer\">
                <input class=\"segmentFilter browser-default\" type=\"text\" tabindex=\"4\" value=\"\" placeholder=\"{{ 'General_Search'|translate }}\"/>
                <span></span>
            </div>
            <ul class=\"submenu\">
                <li>{{ 'SegmentEditor_SelectSegmentOfVisits'|translate }}
                    <div class=\"segmentList\">
                        <ul>
                        </ul>
                    </div>
                </li>
            </ul>

            {% if authorizedToCreateSegments %}
                <button tabindex=\"4\" class=\"add_new_segment btn\">
                    <span class=\"icon-add\"></span>&nbsp;
                    {{ 'SegmentEditor_AddNewSegment'|translate }}
                </button>
                <a href=\"index.php?{{ manageSegmentUrl|urlRewriteWithParameters|slice(1) }}\" tabindex=\"4\" class=\"btn btn-block btn-outline\">
                    {{ 'SegmentEditor_ManageSegments'|translate }}
                </a>
            {% else %}
                <hr/>
                <ul class=\"submenu\">
                <li>
                    {% if isUserAnonymous %}
                        <span class='youMustBeLoggedIn'>{{ 'SegmentEditor_YouMustBeLoggedInToCreateSegments'|translate }}
                        <br/>&rsaquo; <a href='index.php?module={{ loginModule }}'>{{ 'Login_LogIn'|translate }}</a> </span>
                    {% endif %}
                </li>
                </ul>
                <br/><br/>
            {% endif %}
        </div>
    </div>

    <div class=\"segment-element borderedControl expanded\">

        <div class=\"segment-content\">
            <div class=\"segment-top\" {% if not isSuperUser %}style=\"display:none\"{% endif %}>
               <input type=\"hidden\" class=\"available_segments_select\"/>
               <div class=\"segment-top-item grid-1\">
                {{ 'SegmentEditor_ThisSegmentIsVisibleTo'|translate }} <div class=\"enable_all_users\"><strong>
                        <select class=\"enable_all_users_select\">
                            <option {% if not isSuperUser %}selected=\"1\"{% endif %} value=\"0\">{{ 'SegmentEditor_VisibleToMe'|translate }}</option>
                            <option {% if isSuperUser %}selected=\"1\"{% endif %} value=\"1\">{{ 'SegmentEditor_VisibleToAllUsers'|translate }}</option>
                        </select>
                    </strong></div>
                </div>
                <div class=\"segment-top-item grid-2\">
                {{ 'SegmentEditor_SegmentIsDisplayedForWebsite'|translate }}<div class=\"visible_to_website\"><strong>
                        <select class=\"visible_to_website_select\">
                            <option selected=\"\" value=\"{{ idSite }}\">{{ 'SegmentEditor_SegmentDisplayedThisWebsiteOnly'|translate }}</option>
                            {% if isAddingSegmentsForAllWebsitesEnabled %}<option value=\"0\">{{ 'SegmentEditor_SegmentDisplayedAllWebsites'|translate }}</option>{% endif %}
                        </select>
                    </strong></div>
                </div>
                {% if isCreateRealtimeSegmentsEnabled %}
                   <div class=\"segment-top-item grid-3\">
                    {{ 'General_And'|translate }}
                    <div class=\"auto_archive\"><strong>
                            <select class=\"auto_archive_select\">
                                {% if createRealTimeSegmentsIsEnabled %}
                                    <option {% if isBrowserArchivingEnabled %}selected=\"1\"{% endif%} value=\"0\">{{ 'SegmentEditor_AutoArchiveRealTime'|translate }}</option>
                                {% endif %}
                                <option {% if not isBrowserArchivingEnabled or not createRealTimeSegmentsIsEnabled %}selected=\"1\"{% endif %} value=\"1\">{{ 'SegmentEditor_AutoArchivePreProcessed'|translate }} </option>
                            </select>
                        </strong>
                    </div>
                   </div>
                {% endif %}

            </div>
            <h3 style=\"margin: 12px 6px;\">{{ 'General_Name'|translate }}: <span  class=\"segmentName\"></span> <a class=\"editSegmentName\" href=\"#\">{{ 'General_Edit'|translate|lower }}</a></h3>
        </div>
        <div class=\"segment-footer\">
            <div vue-entry=\"Feedback.RateFeature\" title=\"&quot;{{ 'SegmentEditor_SegmentEditor'|translate }}&quot;\" style=\"display:inline-block;float: left;margin-top: 2px;margin-right: 10px;\"></div>
            <a class=\"btn-flat delete\" href=\"#\">{{ 'General_Delete'|translate }}</a>
            <a class=\"btn-flat close\" href=\"#\">{{ 'General_Close'|translate }}</a>
            {% if isVisitorLogEnabled %}
                <a class=\"btn-flat testSegment\">{{ 'SegmentEditor_Test'|translate }}</a>
            {% endif %}
            <button class=\"btn saveAndApply\">{{ 'SegmentEditor_SaveAndApply'|translate|raw }}</button>
        </div>
    </div>
</div>
<div class=\"segmentListContainer\">
<div
    vue-entry=\"SegmentEditor.SegmentSelector\"
    manage-segments-url=\"index.php?{{ manageSegmentUrl|urlRewriteWithParameters|slice(1) }}\"
    is-user-anonymous=\"{{ isUserAnonymous|json_encode|e('html_attr') }}\"
    login-url=\"index.php?module={{ loginModule|e('html_attr') }}\"
></div>
<div class=\"ui-confirm\" id=\"segment-delete-confirm\">
    <h2>{{ 'SegmentEditor_AreYouSureDeleteSegment'|translate }}</h2>
    <input role=\"yes\" type=\"button\" value=\"{{ 'General_Yes'|translate }}\"/>
    <input role=\"no\" type=\"button\" value=\"{{ 'General_No'|translate }}\"/>
</div>
<div class=\"ui-confirm segment-definition-change-confirm\" data-segment-processed-on-request=\"{{ segmentProcessedOnRequest|number_format }}\" data-hide-message=\"{{ hideSegmentDefinitionChangeMessage }}\">
    <h2>
        <span class=\"process-on-request\">
            {{ 'SegmentEditor_ChangingSegmentDefinitionConfirmationProcessedOnRequest'|translate }}
        </span>
        <span class=\"no-process-on-request\">
            {{ 'SegmentEditor_ChangingSegmentDefinitionConfirmationNotProcessedOnRequest'|translate }}
        </span>
    </h2>
    <p class=\"description\">
        <span>
            <label>
                <input type=\"checkbox\" id=\"hideSegmentMessage\" name=\"hideSegmentMessage\" />
                <span>{{ 'SegmentEditor_HideMessageInFuture'|translate }}</span>
            </label>
        </span>
    </p>
    <input role=\"yes\" type=\"button\" value=\"{{ 'General_Yes'|translate }}\"/>
    <input role=\"no\" type=\"button\" value=\"{{ 'General_No'|translate }}\"/>
</div>
<div class=\"ui-confirm pleaseChangeBrowserAchivingDisabledSetting\">
    <h2>{{ 'SegmentEditor_SegmentNotApplied'|translate(nameOfCurrentSegment)|rawSafeDecoded|raw }}</h2>
    {% set segmentSetting %}{{ 'SegmentEditor_AutoArchivePreProcessed'|translate }}{% endset %}
    <p class=\"description\">
        {{ 'SegmentEditor_SegmentNotAppliedMessage'|translate(nameOfCurrentSegment)|rawSafeDecoded|raw }}
        <br/>
        {{ 'SegmentEditor_DataAvailableAtLaterDate'|translate }}
        {% if isSuperUser %}
            <br/> <br/> {{ 'SegmentEditor_YouMayChangeSetting'|translate('browser_archiving_disabled_enforce', segmentSetting) }}
        {% endif %}
    </p>

    <input role=\"yes\" type=\"button\" value=\"{{ 'General_Ok'|translate }}\"/>
</div>
</div>
", "@SegmentEditor/_segmentSelector.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/SegmentEditor/templates/_segmentSelector.twig");
    }
}
