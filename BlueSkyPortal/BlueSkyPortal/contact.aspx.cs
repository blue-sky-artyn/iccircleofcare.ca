using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using Cruder.Core;
using bluesky.artyn;

public partial class contact : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        string companyDetStr = string.Empty;
        tblCompanyCollection companyTbl = new tblCompanyCollection();
        companyTbl.ReadList();

        #region contact details
        if (companyTbl.Count > 0)
        {
            if (companyTbl[0].Tel.Length > 0)
                companyDetStr += "<small>Phone: " + companyTbl[0].Tel + "</small>";

            if (companyTbl[0].Phone.Length > 0)
                companyDetStr += "<small>Fax:  " + companyTbl[0].Phone + "</small>";

            if (companyTbl[0].Email.Length > 0)
                companyDetStr += "<p><a href='mail:" + companyTbl[0].Email + "'>" + companyTbl[0].Email + "</a></p>";

            if (companyTbl[0].website.Length > 0)
                companyDetStr += "<p><a href='" + companyTbl[0].website + "'>" + companyTbl[0].website + "</a></p>";
        }
        contactDetHtml.InnerHtml = companyDetStr;
        #endregion

        #region contact address
        if (companyTbl.Count > 0)
            contactAddrHtml.InnerHtml = "<small>" + companyTbl[0].CoAddr + "</small>";
        else
            contactAddrHtml.InnerHtml = "";
        #endregion

        #region social links
        companyDetStr = "";
        if (companyTbl.Count > 0)
        {
            if (companyTbl[0].Facebook.Length > 0)
                companyDetStr += "<small><a href='" + companyTbl[0].Facebook + "'><i class='font-awsome-icon fa fa-facebook-official' aria-hidden='true' style='font-size:17px;color:#3b5999;display: inline-block;'></i>Facebook</a></small>";

            if (companyTbl[0].Twitter.Length > 0)
                companyDetStr += "<small><a href='" + companyTbl[0].Twitter + "'><i class='font-awsome-icon fa fa-twitter-square' aria-hidden='true' style='font-size:17px;color:#00aced;display: inline-block;'></i>Twitter</a></small>";

            if (companyTbl[0].Instagram.Length > 0)
                companyDetStr += "<small><a href='" + companyTbl[0].Instagram + "'><i class='font-awsome-icon fa fa-instagram' aria-hidden='true' style='font-size:17px;color:#d44332;display: inline-block;'></i>Instagram</a></small>";

            if (companyTbl[0].SocialNumber.Length > 0)
                companyDetStr += "<small><a href='" + companyTbl[0].SocialNumber + "'><i class='font-awsome-icon fa fa-whatsapp' aria-hidden='true' style='font-size:17px;color:#1cb39b;display: inline-block;'></i>WhatsApp</a></small>";

            if (companyTbl[0].Telegram.Length > 0)
                companyDetStr += "<small><a href='" + companyTbl[0].Telegram + "'><i class='font-awsome-icon fa fa-telegram' aria-hidden='true' style='font-size:17px;color#179cde;display: inline-block;'></i>Telegram</a></small>";

            if (companyTbl[0].Linkedin.Length > 0)
                companyDetStr += "<small><a href='" + companyTbl[0].Linkedin + "'><i class='font-awsome-icon fa fa-linkedin-square' aria-hidden='true' style='font-size:17px;color:#2977c9;display: inline-block;'></i>LinkedIn</a></small>";

            if (companyTbl[0].youtube.Length > 0)
                companyDetStr += "<small><a href='" + companyTbl[0].youtube + "'><i class='font-awsome-icon fa fa-youtube-square' aria-hidden='true' style='font-size:17px;color:#f00;display: inline-block;'></i>YouTube</a></small>";

        }
        socialLinkHtml.InnerHtml = companyDetStr;

        #endregion


    }
}