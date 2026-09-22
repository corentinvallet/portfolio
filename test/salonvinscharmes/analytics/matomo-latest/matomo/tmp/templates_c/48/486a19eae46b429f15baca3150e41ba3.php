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

/* @Login/login.twig */
class __TwigTemplate_9854e990fbe3187bebd5cb7b5916a0a5 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'loginContent' => [$this, 'block_loginContent'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 2
        return "@Login/loginLayout.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("@Login/loginLayout.twig", "@Login/login.twig", 2);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_loginContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        yield "    <div class=\"contentForm loginForm\">
        ";
        // line 6
        yield from         $this->loadTemplate("@Login/login.twig", "@Login/login.twig", 6, "826747126")->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->env->getFilter('translate')->getCallable()("Login_LogIn")]));
        // line 114
        yield "    </div>
    <div class=\"contentForm resetForm loginForm\" style=\"display:none;\">
        ";
        // line 116
        yield from         $this->loadTemplate("@Login/login.twig", "@Login/login.twig", 116, "1029744954")->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->env->getFilter('translate')->getCallable()("Login_ChangeYourPassword")]));
        // line 203
        yield "    </div>

";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@Login/login.twig";
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
        return array (  62 => 203,  60 => 116,  56 => 114,  54 => 6,  51 => 5,  47 => 4,  36 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("
{% extends '@Login/loginLayout.twig' %}

{% block loginContent %}
    <div class=\"contentForm loginForm\">
        {% embed 'contentBlock.twig' with {'title': 'Login_LogIn'|translate} %}
            {% block content %}
                <p class=\"loginForm__intro\">{{ 'Login_SignInIntro'|translate }}</p>

                <div class=\"message_container\">

                    {{ include('@Login/_formErrors.twig', {formErrors: form_data.errors } )  }}

                    {% if AccessErrorString %}
                        <div vue-entry=\"CoreHome.Notification\"
                             noclear=\"true\"
                             context=\"error\">
                            <strong>{{ 'General_Error'|translate }}</strong>: {{ AccessErrorString|raw }}<br/>
                        </div>
                    {% endif %}

                    {% if infoMessage %}
                        <div class=\"alert alert-info\">{{ infoMessage|raw }}</div>
                    {% endif %}
                </div>
                <form class=\"loginForm__form\" {{ form_data.attributes|raw }}>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"text\" name=\"form_login\" id=\"login_form_login\" class=\"input\" value=\"\" size=\"20\"
                                               placeholder=\"\" autocomplete=\"username\" autocorrect=\"off\" autocapitalize=\"none\"
                                               spellcheck=\"false\" tabindex=\"10\" autofocus=\"autofocus\" required />
                                        <label for=\"login_form_login\">
                                            <i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"hidden\" name=\"form_nonce\" id=\"login_form_nonce\" value=\"{{ nonce }}\"/>
                                        <input type=\"hidden\" name=\"form_redirect\" id=\"login_form_redirect\" value=\"\"/>
                                        <input type=\"password\" name=\"form_password\" id=\"login_form_password\" class=\"input\"
                                               value=\"\" size=\"20\" placeholder=\"\" autocomplete=\"current-password\" autocorrect=\"off\"
                                               autocapitalize=\"none\" spellcheck=\"false\" tabindex=\"20\" required
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <label for=\"login_form_password\">
                                            <i class=\"icon-locked icon\"></i> {{ 'General_Password'|translate }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row loginForm__row--spacious\">
                        <div class=\"row actions\">
                            <div class=\"col s6\">
                                <div class=\"loginForm__field\">
                                    <label>
                                        <input name=\"form_rememberme\" type=\"checkbox\" id=\"login_form_rememberme\" value=\"1\"
                                               class=\"loginForm__rememberMe\" tabindex=\"90\"
                                               {% if form_data.form_rememberme.value %}checked=\"checked\" {% endif %}/>
                                        <span>{{ 'Login_RememberMe'|translate }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class=\"col s6 right-align\">
                                <div class=\"loginForm__field\">
                                    <a id=\"login_form_nav\" class=\"loginForm__link\" href=\"#\" tabindex=\"95\"
                                       title=\"{{ 'Login_LostYourPassword'|translate }}\">
                                        {{ 'Login_LostYourPassword'|translate }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row loginForm__row--noGap\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <input class=\"submit btn btn-block\" id=\"login_form_submit\" type=\"submit\"
                                           value=\"{{ 'Login_LogIn'|translate }}\" tabindex=\"100\"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class=\"row\">
                    <div class=\"col s12\">
                        {{ postEvent(\"Template.loginNav\", \"top\") }}
                        {{ postEvent(\"Template.loginNav\", \"bottom\") }}
                    </div>
                </div>

                {% if isCustomLogo %}
                    <p id=\"piwik\">
                        <i><a href=\"{{ 'https://matomo.org/'|trackmatomolink }}\" rel=\"noreferrer noopener\" target=\"_blank\">{{ linkTitle }}</a></i>
                    </p>
                {% endif %}

            {% endblock %}
        {% endembed %}
    </div>
    <div class=\"contentForm resetForm loginForm\" style=\"display:none;\">
        {% embed 'contentBlock.twig' with {'title': 'Login_ChangeYourPassword'|translate} %}
            {% block content %}

                <div class=\"message_container\">
                </div>

                <form id=\"reset_form\" class=\"loginForm__form\" method=\"post\">
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"hidden\" name=\"form_nonce\" id=\"reset_form_nonce\" value=\"{{ nonce }}\"/>
                                        <input type=\"text\" placeholder=\"\" name=\"form_login\" id=\"reset_form_login\" class=\"input\" value=\"\" size=\"20\"
                                               autocorrect=\"off\" autocapitalize=\"none\"
                                               tabindex=\"10\"/>
                                        <label for=\"reset_form_login\"><i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"reset_form_password\" class=\"input\" value=\"\" size=\"20\"
                                               autocorrect=\"off\" autocapitalize=\"none\" spellcheck=\"false\"
                                               tabindex=\"20\" autocomplete=\"off\"
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <div vue-entry=\"CoreHome.PasswordStrength\"
                                             external-input-selector=\"#reset_form_password\"
                                             validation-rules=\"{{ passwordStrengthValidationRules|json_encode }}\"
                                        ></div>
                                        <label for=\"reset_form_password\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPassword'|translate }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"password\" placeholder=\"\" name=\"form_password_bis\" id=\"reset_form_password_bis\" class=\"input\" value=\"\"
                                               autocorrect=\"off\" autocapitalize=\"none\" spellcheck=\"false\"
                                               size=\"20\" tabindex=\"30\" autocomplete=\"off\"
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <div vue-entry=\"CoreHome.PasswordStrength\"
                                             external-input-selector=\"#reset_form_password_bis\"
                                             validation-rules=\"{{ passwordStrengthValidationRules|json_encode }}\"
                                        ></div>
                                        <label for=\"reset_form_password_bis\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPasswordRepeat'|translate }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row\">
                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <input class=\"submit btn btn-block\" id='reset_form_submit' type=\"submit\"
                                           value=\"{{ 'General_ChangePassword'|translate }}\" tabindex=\"100\"/>

                                    <span class=\"loadingPiwik\" style=\"display:none;\">
                                        {% include \"@CoreHome/_loader.twig\" %}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type=\"hidden\" name=\"module\" value=\"{{ loginModule }}\"/>
                    <input type=\"hidden\" name=\"action\" value=\"resetPassword\"/>
                </form>
                <p id=\"nav\">
                    <a id=\"reset_form_nav\" href=\"#\"
                       title=\"{{ 'Mobile_NavigationBack'|translate }}\">{{ 'General_Cancel'|translate }}</a>
                    <a id=\"alternate_reset_nav\" href=\"#\" style=\"display:none;\"
                       title=\"{{'Login_LogIn'|translate}}\">{{ 'Login_LogIn'|translate }}</a>
                </p>
            {% endblock %}
        {% endembed %}
    </div>

{% endblock %}
", "@Login/login.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Login/templates/login.twig");
    }
}


/* @Login/login.twig */
class __TwigTemplate_9854e990fbe3187bebd5cb7b5916a0a5___826747126 extends Template
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
        // line 6
        return "contentBlock.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("contentBlock.twig", "@Login/login.twig", 6);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 7
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        yield "                <p class=\"loginForm__intro\">";
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_SignInIntro"), "html", null, true);
        yield "</p>

                <div class=\"message_container\">

                    ";
        // line 12
        yield Twig\Extension\CoreExtension::include($this->env, $context, "@Login/_formErrors.twig", ["formErrors" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["form_data"]) || array_key_exists("form_data", $context) ? $context["form_data"] : (function () { throw new RuntimeError('Variable "form_data" does not exist.', 12, $this->source); })()), "errors", [], "any", false, false, false, 12)]);
        yield "

                    ";
        // line 14
        if ((isset($context["AccessErrorString"]) || array_key_exists("AccessErrorString", $context) ? $context["AccessErrorString"] : (function () { throw new RuntimeError('Variable "AccessErrorString" does not exist.', 14, $this->source); })())) {
            // line 15
            yield "                        <div vue-entry=\"CoreHome.Notification\"
                             noclear=\"true\"
                             context=\"error\">
                            <strong>";
            // line 18
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Error"), "html", null, true);
            yield "</strong>: ";
            yield (isset($context["AccessErrorString"]) || array_key_exists("AccessErrorString", $context) ? $context["AccessErrorString"] : (function () { throw new RuntimeError('Variable "AccessErrorString" does not exist.', 18, $this->source); })());
            yield "<br/>
                        </div>
                    ";
        }
        // line 21
        yield "
                    ";
        // line 22
        if ((isset($context["infoMessage"]) || array_key_exists("infoMessage", $context) ? $context["infoMessage"] : (function () { throw new RuntimeError('Variable "infoMessage" does not exist.', 22, $this->source); })())) {
            // line 23
            yield "                        <div class=\"alert alert-info\">";
            yield (isset($context["infoMessage"]) || array_key_exists("infoMessage", $context) ? $context["infoMessage"] : (function () { throw new RuntimeError('Variable "infoMessage" does not exist.', 23, $this->source); })());
            yield "</div>
                    ";
        }
        // line 25
        yield "                </div>
                <form class=\"loginForm__form\" ";
        // line 26
        yield CoreExtension::getAttribute($this->env, $this->source, (isset($context["form_data"]) || array_key_exists("form_data", $context) ? $context["form_data"] : (function () { throw new RuntimeError('Variable "form_data" does not exist.', 26, $this->source); })()), "attributes", [], "any", false, false, false, 26);
        yield ">
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"text\" name=\"form_login\" id=\"login_form_login\" class=\"input\" value=\"\" size=\"20\"
                                               placeholder=\"\" autocomplete=\"username\" autocorrect=\"off\" autocapitalize=\"none\"
                                               spellcheck=\"false\" tabindex=\"10\" autofocus=\"autofocus\" required />
                                        <label for=\"login_form_login\">
                                            <i class=\"icon-user icon\"></i> ";
        // line 36
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_LoginOrEmail"), "html", null, true);
        yield "
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"hidden\" name=\"form_nonce\" id=\"login_form_nonce\" value=\"";
        // line 49
        yield \Piwik\piwik_escape_filter($this->env, (isset($context["nonce"]) || array_key_exists("nonce", $context) ? $context["nonce"] : (function () { throw new RuntimeError('Variable "nonce" does not exist.', 49, $this->source); })()), "html", null, true);
        yield "\"/>
                                        <input type=\"hidden\" name=\"form_redirect\" id=\"login_form_redirect\" value=\"\"/>
                                        <input type=\"password\" name=\"form_password\" id=\"login_form_password\" class=\"input\"
                                               value=\"\" size=\"20\" placeholder=\"\" autocomplete=\"current-password\" autocorrect=\"off\"
                                               autocapitalize=\"none\" spellcheck=\"false\" tabindex=\"20\" required
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <label for=\"login_form_password\">
                                            <i class=\"icon-locked icon\"></i> ";
        // line 56
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Password"), "html", null, true);
        yield "
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row loginForm__row--spacious\">
                        <div class=\"row actions\">
                            <div class=\"col s6\">
                                <div class=\"loginForm__field\">
                                    <label>
                                        <input name=\"form_rememberme\" type=\"checkbox\" id=\"login_form_rememberme\" value=\"1\"
                                               class=\"loginForm__rememberMe\" tabindex=\"90\"
                                               ";
        // line 71
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["form_data"]) || array_key_exists("form_data", $context) ? $context["form_data"] : (function () { throw new RuntimeError('Variable "form_data" does not exist.', 71, $this->source); })()), "form_rememberme", [], "any", false, false, false, 71), "value", [], "any", false, false, false, 71)) {
            yield "checked=\"checked\" ";
        }
        yield "/>
                                        <span>";
        // line 72
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_RememberMe"), "html", null, true);
        yield "</span>
                                    </label>
                                </div>
                            </div>
                            <div class=\"col s6 right-align\">
                                <div class=\"loginForm__field\">
                                    <a id=\"login_form_nav\" class=\"loginForm__link\" href=\"#\" tabindex=\"95\"
                                       title=\"";
        // line 79
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_LostYourPassword"), "html", null, true);
        yield "\">
                                        ";
        // line 80
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_LostYourPassword"), "html", null, true);
        yield "
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row loginForm__row--noGap\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <input class=\"submit btn btn-block\" id=\"login_form_submit\" type=\"submit\"
                                           value=\"";
        // line 91
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_LogIn"), "html", null, true);
        yield "\" tabindex=\"100\"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class=\"row\">
                    <div class=\"col s12\">
                        ";
        // line 101
        yield $this->env->getFunction('postEvent')->getCallable()("Template.loginNav", "top");
        yield "
                        ";
        // line 102
        yield $this->env->getFunction('postEvent')->getCallable()("Template.loginNav", "bottom");
        yield "
                    </div>
                </div>

                ";
        // line 106
        if ((isset($context["isCustomLogo"]) || array_key_exists("isCustomLogo", $context) ? $context["isCustomLogo"] : (function () { throw new RuntimeError('Variable "isCustomLogo" does not exist.', 106, $this->source); })())) {
            // line 107
            yield "                    <p id=\"piwik\">
                        <i><a href=\"";
            // line 108
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('trackmatomolink')->getCallable()("https://matomo.org/"), "html", null, true);
            yield "\" rel=\"noreferrer noopener\" target=\"_blank\">";
            yield \Piwik\piwik_escape_filter($this->env, (isset($context["linkTitle"]) || array_key_exists("linkTitle", $context) ? $context["linkTitle"] : (function () { throw new RuntimeError('Variable "linkTitle" does not exist.', 108, $this->source); })()), "html", null, true);
            yield "</a></i>
                    </p>
                ";
        }
        // line 111
        yield "
            ";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@Login/login.twig";
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
        return array (  509 => 111,  501 => 108,  498 => 107,  496 => 106,  489 => 102,  485 => 101,  472 => 91,  458 => 80,  454 => 79,  444 => 72,  438 => 71,  420 => 56,  410 => 49,  394 => 36,  381 => 26,  378 => 25,  372 => 23,  370 => 22,  367 => 21,  359 => 18,  354 => 15,  352 => 14,  347 => 12,  339 => 8,  335 => 7,  324 => 6,  62 => 203,  60 => 116,  56 => 114,  54 => 6,  51 => 5,  47 => 4,  36 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("
{% extends '@Login/loginLayout.twig' %}

{% block loginContent %}
    <div class=\"contentForm loginForm\">
        {% embed 'contentBlock.twig' with {'title': 'Login_LogIn'|translate} %}
            {% block content %}
                <p class=\"loginForm__intro\">{{ 'Login_SignInIntro'|translate }}</p>

                <div class=\"message_container\">

                    {{ include('@Login/_formErrors.twig', {formErrors: form_data.errors } )  }}

                    {% if AccessErrorString %}
                        <div vue-entry=\"CoreHome.Notification\"
                             noclear=\"true\"
                             context=\"error\">
                            <strong>{{ 'General_Error'|translate }}</strong>: {{ AccessErrorString|raw }}<br/>
                        </div>
                    {% endif %}

                    {% if infoMessage %}
                        <div class=\"alert alert-info\">{{ infoMessage|raw }}</div>
                    {% endif %}
                </div>
                <form class=\"loginForm__form\" {{ form_data.attributes|raw }}>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"text\" name=\"form_login\" id=\"login_form_login\" class=\"input\" value=\"\" size=\"20\"
                                               placeholder=\"\" autocomplete=\"username\" autocorrect=\"off\" autocapitalize=\"none\"
                                               spellcheck=\"false\" tabindex=\"10\" autofocus=\"autofocus\" required />
                                        <label for=\"login_form_login\">
                                            <i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"hidden\" name=\"form_nonce\" id=\"login_form_nonce\" value=\"{{ nonce }}\"/>
                                        <input type=\"hidden\" name=\"form_redirect\" id=\"login_form_redirect\" value=\"\"/>
                                        <input type=\"password\" name=\"form_password\" id=\"login_form_password\" class=\"input\"
                                               value=\"\" size=\"20\" placeholder=\"\" autocomplete=\"current-password\" autocorrect=\"off\"
                                               autocapitalize=\"none\" spellcheck=\"false\" tabindex=\"20\" required
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <label for=\"login_form_password\">
                                            <i class=\"icon-locked icon\"></i> {{ 'General_Password'|translate }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row loginForm__row--spacious\">
                        <div class=\"row actions\">
                            <div class=\"col s6\">
                                <div class=\"loginForm__field\">
                                    <label>
                                        <input name=\"form_rememberme\" type=\"checkbox\" id=\"login_form_rememberme\" value=\"1\"
                                               class=\"loginForm__rememberMe\" tabindex=\"90\"
                                               {% if form_data.form_rememberme.value %}checked=\"checked\" {% endif %}/>
                                        <span>{{ 'Login_RememberMe'|translate }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class=\"col s6 right-align\">
                                <div class=\"loginForm__field\">
                                    <a id=\"login_form_nav\" class=\"loginForm__link\" href=\"#\" tabindex=\"95\"
                                       title=\"{{ 'Login_LostYourPassword'|translate }}\">
                                        {{ 'Login_LostYourPassword'|translate }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row loginForm__row--noGap\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <input class=\"submit btn btn-block\" id=\"login_form_submit\" type=\"submit\"
                                           value=\"{{ 'Login_LogIn'|translate }}\" tabindex=\"100\"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class=\"row\">
                    <div class=\"col s12\">
                        {{ postEvent(\"Template.loginNav\", \"top\") }}
                        {{ postEvent(\"Template.loginNav\", \"bottom\") }}
                    </div>
                </div>

                {% if isCustomLogo %}
                    <p id=\"piwik\">
                        <i><a href=\"{{ 'https://matomo.org/'|trackmatomolink }}\" rel=\"noreferrer noopener\" target=\"_blank\">{{ linkTitle }}</a></i>
                    </p>
                {% endif %}

            {% endblock %}
        {% endembed %}
    </div>
    <div class=\"contentForm resetForm loginForm\" style=\"display:none;\">
        {% embed 'contentBlock.twig' with {'title': 'Login_ChangeYourPassword'|translate} %}
            {% block content %}

                <div class=\"message_container\">
                </div>

                <form id=\"reset_form\" class=\"loginForm__form\" method=\"post\">
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"hidden\" name=\"form_nonce\" id=\"reset_form_nonce\" value=\"{{ nonce }}\"/>
                                        <input type=\"text\" placeholder=\"\" name=\"form_login\" id=\"reset_form_login\" class=\"input\" value=\"\" size=\"20\"
                                               autocorrect=\"off\" autocapitalize=\"none\"
                                               tabindex=\"10\"/>
                                        <label for=\"reset_form_login\"><i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"reset_form_password\" class=\"input\" value=\"\" size=\"20\"
                                               autocorrect=\"off\" autocapitalize=\"none\" spellcheck=\"false\"
                                               tabindex=\"20\" autocomplete=\"off\"
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <div vue-entry=\"CoreHome.PasswordStrength\"
                                             external-input-selector=\"#reset_form_password\"
                                             validation-rules=\"{{ passwordStrengthValidationRules|json_encode }}\"
                                        ></div>
                                        <label for=\"reset_form_password\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPassword'|translate }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"password\" placeholder=\"\" name=\"form_password_bis\" id=\"reset_form_password_bis\" class=\"input\" value=\"\"
                                               autocorrect=\"off\" autocapitalize=\"none\" spellcheck=\"false\"
                                               size=\"20\" tabindex=\"30\" autocomplete=\"off\"
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <div vue-entry=\"CoreHome.PasswordStrength\"
                                             external-input-selector=\"#reset_form_password_bis\"
                                             validation-rules=\"{{ passwordStrengthValidationRules|json_encode }}\"
                                        ></div>
                                        <label for=\"reset_form_password_bis\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPasswordRepeat'|translate }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row\">
                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <input class=\"submit btn btn-block\" id='reset_form_submit' type=\"submit\"
                                           value=\"{{ 'General_ChangePassword'|translate }}\" tabindex=\"100\"/>

                                    <span class=\"loadingPiwik\" style=\"display:none;\">
                                        {% include \"@CoreHome/_loader.twig\" %}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type=\"hidden\" name=\"module\" value=\"{{ loginModule }}\"/>
                    <input type=\"hidden\" name=\"action\" value=\"resetPassword\"/>
                </form>
                <p id=\"nav\">
                    <a id=\"reset_form_nav\" href=\"#\"
                       title=\"{{ 'Mobile_NavigationBack'|translate }}\">{{ 'General_Cancel'|translate }}</a>
                    <a id=\"alternate_reset_nav\" href=\"#\" style=\"display:none;\"
                       title=\"{{'Login_LogIn'|translate}}\">{{ 'Login_LogIn'|translate }}</a>
                </p>
            {% endblock %}
        {% endembed %}
    </div>

{% endblock %}
", "@Login/login.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Login/templates/login.twig");
    }
}


/* @Login/login.twig */
class __TwigTemplate_9854e990fbe3187bebd5cb7b5916a0a5___1029744954 extends Template
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
        // line 116
        return "contentBlock.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("contentBlock.twig", "@Login/login.twig", 116);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 117
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 118
        yield "
                <div class=\"message_container\">
                </div>

                <form id=\"reset_form\" class=\"loginForm__form\" method=\"post\">
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"hidden\" name=\"form_nonce\" id=\"reset_form_nonce\" value=\"";
        // line 128
        yield \Piwik\piwik_escape_filter($this->env, (isset($context["nonce"]) || array_key_exists("nonce", $context) ? $context["nonce"] : (function () { throw new RuntimeError('Variable "nonce" does not exist.', 128, $this->source); })()), "html", null, true);
        yield "\"/>
                                        <input type=\"text\" placeholder=\"\" name=\"form_login\" id=\"reset_form_login\" class=\"input\" value=\"\" size=\"20\"
                                               autocorrect=\"off\" autocapitalize=\"none\"
                                               tabindex=\"10\"/>
                                        <label for=\"reset_form_login\"><i class=\"icon-user icon\"></i> ";
        // line 132
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_LoginOrEmail"), "html", null, true);
        yield "</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"reset_form_password\" class=\"input\" value=\"\" size=\"20\"
                                               autocorrect=\"off\" autocapitalize=\"none\" spellcheck=\"false\"
                                               tabindex=\"20\" autocomplete=\"off\"
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <div vue-entry=\"CoreHome.PasswordStrength\"
                                             external-input-selector=\"#reset_form_password\"
                                             validation-rules=\"";
        // line 149
        yield \Piwik\piwik_escape_filter($this->env, json_encode((isset($context["passwordStrengthValidationRules"]) || array_key_exists("passwordStrengthValidationRules", $context) ? $context["passwordStrengthValidationRules"] : (function () { throw new RuntimeError('Variable "passwordStrengthValidationRules" does not exist.', 149, $this->source); })())), "html", null, true);
        yield "\"
                                        ></div>
                                        <label for=\"reset_form_password\"><i class=\"icon-locked icon\"></i> ";
        // line 151
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_NewPassword"), "html", null, true);
        yield "</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"password\" placeholder=\"\" name=\"form_password_bis\" id=\"reset_form_password_bis\" class=\"input\" value=\"\"
                                               autocorrect=\"off\" autocapitalize=\"none\" spellcheck=\"false\"
                                               size=\"20\" tabindex=\"30\" autocomplete=\"off\"
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <div vue-entry=\"CoreHome.PasswordStrength\"
                                             external-input-selector=\"#reset_form_password_bis\"
                                             validation-rules=\"";
        // line 168
        yield \Piwik\piwik_escape_filter($this->env, json_encode((isset($context["passwordStrengthValidationRules"]) || array_key_exists("passwordStrengthValidationRules", $context) ? $context["passwordStrengthValidationRules"] : (function () { throw new RuntimeError('Variable "passwordStrengthValidationRules" does not exist.', 168, $this->source); })())), "html", null, true);
        yield "\"
                                        ></div>
                                        <label for=\"reset_form_password_bis\"><i class=\"icon-locked icon\"></i> ";
        // line 170
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_NewPasswordRepeat"), "html", null, true);
        yield "</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row\">
                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <input class=\"submit btn btn-block\" id='reset_form_submit' type=\"submit\"
                                           value=\"";
        // line 182
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_ChangePassword"), "html", null, true);
        yield "\" tabindex=\"100\"/>

                                    <span class=\"loadingPiwik\" style=\"display:none;\">
                                        ";
        // line 185
        yield from         $this->loadTemplate("@CoreHome/_loader.twig", "@Login/login.twig", 185)->unwrap()->yield($context);
        // line 186
        yield "                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type=\"hidden\" name=\"module\" value=\"";
        // line 192
        yield \Piwik\piwik_escape_filter($this->env, (isset($context["loginModule"]) || array_key_exists("loginModule", $context) ? $context["loginModule"] : (function () { throw new RuntimeError('Variable "loginModule" does not exist.', 192, $this->source); })()), "html", null, true);
        yield "\"/>
                    <input type=\"hidden\" name=\"action\" value=\"resetPassword\"/>
                </form>
                <p id=\"nav\">
                    <a id=\"reset_form_nav\" href=\"#\"
                       title=\"";
        // line 197
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Mobile_NavigationBack"), "html", null, true);
        yield "\">";
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("General_Cancel"), "html", null, true);
        yield "</a>
                    <a id=\"alternate_reset_nav\" href=\"#\" style=\"display:none;\"
                       title=\"";
        // line 199
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_LogIn"), "html", null, true);
        yield "\">";
        yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("Login_LogIn"), "html", null, true);
        yield "</a>
                </p>
            ";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@Login/login.twig";
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
        return array (  900 => 199,  893 => 197,  885 => 192,  877 => 186,  875 => 185,  869 => 182,  854 => 170,  849 => 168,  829 => 151,  824 => 149,  804 => 132,  797 => 128,  785 => 118,  781 => 117,  770 => 116,  509 => 111,  501 => 108,  498 => 107,  496 => 106,  489 => 102,  485 => 101,  472 => 91,  458 => 80,  454 => 79,  444 => 72,  438 => 71,  420 => 56,  410 => 49,  394 => 36,  381 => 26,  378 => 25,  372 => 23,  370 => 22,  367 => 21,  359 => 18,  354 => 15,  352 => 14,  347 => 12,  339 => 8,  335 => 7,  324 => 6,  62 => 203,  60 => 116,  56 => 114,  54 => 6,  51 => 5,  47 => 4,  36 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("
{% extends '@Login/loginLayout.twig' %}

{% block loginContent %}
    <div class=\"contentForm loginForm\">
        {% embed 'contentBlock.twig' with {'title': 'Login_LogIn'|translate} %}
            {% block content %}
                <p class=\"loginForm__intro\">{{ 'Login_SignInIntro'|translate }}</p>

                <div class=\"message_container\">

                    {{ include('@Login/_formErrors.twig', {formErrors: form_data.errors } )  }}

                    {% if AccessErrorString %}
                        <div vue-entry=\"CoreHome.Notification\"
                             noclear=\"true\"
                             context=\"error\">
                            <strong>{{ 'General_Error'|translate }}</strong>: {{ AccessErrorString|raw }}<br/>
                        </div>
                    {% endif %}

                    {% if infoMessage %}
                        <div class=\"alert alert-info\">{{ infoMessage|raw }}</div>
                    {% endif %}
                </div>
                <form class=\"loginForm__form\" {{ form_data.attributes|raw }}>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"text\" name=\"form_login\" id=\"login_form_login\" class=\"input\" value=\"\" size=\"20\"
                                               placeholder=\"\" autocomplete=\"username\" autocorrect=\"off\" autocapitalize=\"none\"
                                               spellcheck=\"false\" tabindex=\"10\" autofocus=\"autofocus\" required />
                                        <label for=\"login_form_login\">
                                            <i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"hidden\" name=\"form_nonce\" id=\"login_form_nonce\" value=\"{{ nonce }}\"/>
                                        <input type=\"hidden\" name=\"form_redirect\" id=\"login_form_redirect\" value=\"\"/>
                                        <input type=\"password\" name=\"form_password\" id=\"login_form_password\" class=\"input\"
                                               value=\"\" size=\"20\" placeholder=\"\" autocomplete=\"current-password\" autocorrect=\"off\"
                                               autocapitalize=\"none\" spellcheck=\"false\" tabindex=\"20\" required
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <label for=\"login_form_password\">
                                            <i class=\"icon-locked icon\"></i> {{ 'General_Password'|translate }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row loginForm__row--spacious\">
                        <div class=\"row actions\">
                            <div class=\"col s6\">
                                <div class=\"loginForm__field\">
                                    <label>
                                        <input name=\"form_rememberme\" type=\"checkbox\" id=\"login_form_rememberme\" value=\"1\"
                                               class=\"loginForm__rememberMe\" tabindex=\"90\"
                                               {% if form_data.form_rememberme.value %}checked=\"checked\" {% endif %}/>
                                        <span>{{ 'Login_RememberMe'|translate }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class=\"col s6 right-align\">
                                <div class=\"loginForm__field\">
                                    <a id=\"login_form_nav\" class=\"loginForm__link\" href=\"#\" tabindex=\"95\"
                                       title=\"{{ 'Login_LostYourPassword'|translate }}\">
                                        {{ 'Login_LostYourPassword'|translate }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row loginForm__row--noGap\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <input class=\"submit btn btn-block\" id=\"login_form_submit\" type=\"submit\"
                                           value=\"{{ 'Login_LogIn'|translate }}\" tabindex=\"100\"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class=\"row\">
                    <div class=\"col s12\">
                        {{ postEvent(\"Template.loginNav\", \"top\") }}
                        {{ postEvent(\"Template.loginNav\", \"bottom\") }}
                    </div>
                </div>

                {% if isCustomLogo %}
                    <p id=\"piwik\">
                        <i><a href=\"{{ 'https://matomo.org/'|trackmatomolink }}\" rel=\"noreferrer noopener\" target=\"_blank\">{{ linkTitle }}</a></i>
                    </p>
                {% endif %}

            {% endblock %}
        {% endembed %}
    </div>
    <div class=\"contentForm resetForm loginForm\" style=\"display:none;\">
        {% embed 'contentBlock.twig' with {'title': 'Login_ChangeYourPassword'|translate} %}
            {% block content %}

                <div class=\"message_container\">
                </div>

                <form id=\"reset_form\" class=\"loginForm__form\" method=\"post\">
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"hidden\" name=\"form_nonce\" id=\"reset_form_nonce\" value=\"{{ nonce }}\"/>
                                        <input type=\"text\" placeholder=\"\" name=\"form_login\" id=\"reset_form_login\" class=\"input\" value=\"\" size=\"20\"
                                               autocorrect=\"off\" autocapitalize=\"none\"
                                               tabindex=\"10\"/>
                                        <label for=\"reset_form_login\"><i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"reset_form_password\" class=\"input\" value=\"\" size=\"20\"
                                               autocorrect=\"off\" autocapitalize=\"none\" spellcheck=\"false\"
                                               tabindex=\"20\" autocomplete=\"off\"
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <div vue-entry=\"CoreHome.PasswordStrength\"
                                             external-input-selector=\"#reset_form_password\"
                                             validation-rules=\"{{ passwordStrengthValidationRules|json_encode }}\"
                                        ></div>
                                        <label for=\"reset_form_password\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPassword'|translate }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"loginForm__row\">
                        <div class=\"row\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <div class=\"input-field\">
                                        <input type=\"password\" placeholder=\"\" name=\"form_password_bis\" id=\"reset_form_password_bis\" class=\"input\" value=\"\"
                                               autocorrect=\"off\" autocapitalize=\"none\" spellcheck=\"false\"
                                               size=\"20\" tabindex=\"30\" autocomplete=\"off\"
                                               vue-directive=\"CoreHome.AutoClearPassword\" />
                                        <div vue-entry=\"CoreHome.PasswordStrength\"
                                             external-input-selector=\"#reset_form_password_bis\"
                                             validation-rules=\"{{ passwordStrengthValidationRules|json_encode }}\"
                                        ></div>
                                        <label for=\"reset_form_password_bis\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPasswordRepeat'|translate }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"loginForm__row\">
                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <div class=\"loginForm__field\">
                                    <input class=\"submit btn btn-block\" id='reset_form_submit' type=\"submit\"
                                           value=\"{{ 'General_ChangePassword'|translate }}\" tabindex=\"100\"/>

                                    <span class=\"loadingPiwik\" style=\"display:none;\">
                                        {% include \"@CoreHome/_loader.twig\" %}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type=\"hidden\" name=\"module\" value=\"{{ loginModule }}\"/>
                    <input type=\"hidden\" name=\"action\" value=\"resetPassword\"/>
                </form>
                <p id=\"nav\">
                    <a id=\"reset_form_nav\" href=\"#\"
                       title=\"{{ 'Mobile_NavigationBack'|translate }}\">{{ 'General_Cancel'|translate }}</a>
                    <a id=\"alternate_reset_nav\" href=\"#\" style=\"display:none;\"
                       title=\"{{'Login_LogIn'|translate}}\">{{ 'Login_LogIn'|translate }}</a>
                </p>
            {% endblock %}
        {% endembed %}
    </div>

{% endblock %}
", "@Login/login.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/Login/templates/login.twig");
    }
}
