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

/* @SitesManager/_siteWithoutDataCta.twig */
class __TwigTemplate_902f81646ad7ec841872abbbfdb70317 extends Template
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
        if (( !array_key_exists("showInviteTeamMemberLink", $context) || (isset($context["showInviteTeamMemberLink"]) || array_key_exists("showInviteTeamMemberLink", $context) ? $context["showInviteTeamMemberLink"] : (function () { throw new RuntimeError('Variable "showInviteTeamMemberLink" does not exist.', 2, $this->source); })()))) {
            // line 3
            yield "<a rel=\"noreferrer noopener\" target=\"_blank\" href=\"";
            yield \Piwik\piwik_escape_filter($this->env, (isset($context["inviteUserLink"]) || array_key_exists("inviteUserLink", $context) ? $context["inviteUserLink"] : (function () { throw new RuntimeError('Variable "inviteUserLink" does not exist.', 3, $this->source); })()), "html", null, true);
            yield "\">
    <span class=\"icon-user-add\"></span>
    ";
            // line 5
            yield \Piwik\piwik_escape_filter($this->env, $this->env->getFilter('translate')->getCallable()("UsersManager_InviteTeamMember"), "html", null, true);
            yield "
</a>
";
        }
        // line 8
        yield $this->env->getFunction('postEvent')->getCallable()("Template.siteWithoutData.additionalCta");
        yield "
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@SitesManager/_siteWithoutDataCta.twig";
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
        return array (  52 => 8,  46 => 5,  40 => 3,  38 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("{# \"is not defined\" check so a direct render of this partial without the variable still shows the link #}
{% if showInviteTeamMemberLink is not defined or showInviteTeamMemberLink %}
<a rel=\"noreferrer noopener\" target=\"_blank\" href=\"{{ inviteUserLink }}\">
    <span class=\"icon-user-add\"></span>
    {{ 'UsersManager_InviteTeamMember'|translate }}
</a>
{% endif %}
{{ postEvent('Template.siteWithoutData.additionalCta') }}
", "@SitesManager/_siteWithoutDataCta.twig", "/home/u348430936/domains/corentinvallet.fr/public_html/test/salonvinscharmes/analytics/matomo-latest/matomo/plugins/SitesManager/templates/_siteWithoutDataCta.twig");
    }
}
