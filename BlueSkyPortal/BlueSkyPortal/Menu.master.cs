using System;
using System.Collections.Generic;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using bluesky.artyn;
using Cruder.Core;

public partial class Menu : System.Web.UI.MasterPage
{
    protected void Page_Load(object sender, EventArgs e)
    {
        string companyStr = string.Empty;
        tblCompanyCollection companyTbl = new tblCompanyCollection();
        companyTbl.ReadList();

        #region social links

        if (companyTbl.Count > 0)
        {
            if (companyTbl[0].Facebook.Trim().Length > 0)
                companyStr += "<a class='facebook' href='" + companyTbl[0].Facebook + "' data-tooltip='tooltip' data-placement='bottom' title='Facebook'><i class='fa fa-facebook'></i></a>";
            if (companyTbl[0].Twitter.Trim().Length > 0)
                companyStr += "<a class='twitter' href='" + companyTbl[0].Twitter + "' data-tooltip='tooltip' data-placement='bottom' title='Twitter'><i class='fa fa-twitter'></i></a>";
            //if (companyTbl[0].Facebook.Trim().Length > 0)
            //    companyStr += "<a class='google' href='" + companyTbl[0].GooglePlus + "' data-tooltip='tooltip' data-placement='bottom' title='Google Plus'><i class='fa fa-google-plus'></i></a>";
            if (companyTbl[0].Linkedin.Trim().Length > 0)
                companyStr += "<a class='linkedin' href='" + companyTbl[0].Linkedin + "' data-tooltip='tooltip' data-placement='bottom' title='Linkedin'><i class='fa fa-linkedin'></i></a>";
            //if (companyTbl[0].Facebook.Trim().Length > 0)
            //    companyStr += "<a class='pinterest' href='" + companyTbl[0].p + "' data-tooltip='tooltip' data-placement='bottom' title='Pinterest'><i class='fa fa-pinterest'></i></a>";
            if (companyTbl[0].Telegram.Trim().Length > 0)
                companyStr += "<a class='telegram' href='" + companyTbl[0].Telegram + "' data-tooltip='tooltip' data-placement='bottom' title='telegram'><i class='fa fa-telegram' aria-hidden='true'></i></a>";
            if (companyTbl[0].Instagram.Trim().Length > 0)
                companyStr += "<a class='instagram' href='" + companyTbl[0].Instagram + "' data-tooltip='tooltip' data-placement='bottom' title='instagram'><i class='fa fa-instagram' aria-hidden='true'></i></a>";
        }
        socialHtml.InnerHtml = companyStr;

        #endregion

        #region contact det

        companyStr = "";
        if (companyTbl.Count > 0)
        {
            if (companyTbl[0].CoAddr.Trim().Length > 0)
                companyStr += "<strong><i class='fa fa-map-marker' aria-hidden='true'></i></strong> "+ companyTbl[0].CoAddr + "&nbsp;&nbsp;";
            if (companyTbl[0].Tel.Trim().Length > 0)
                companyStr += "<strong><i class='fa fa-phone'></i></strong> " + companyTbl[0].Tel + " &nbsp;&nbsp;";
            if (companyTbl[0].Email.Trim().Length > 0)
                companyStr += "<strong><i class='fa fa-envelope'></i></strong> <a href='mailto:" + companyTbl[0].Email + "'>" + companyTbl[0].Email + "</a>";
        }
        //contactInfoHtml.InnerHtml = companyStr;

        #endregion

        #region products
        companyStr = "";
        tblProductGroupCollection productMainGrpTbl = new tblProductGroupCollection();
        productMainGrpTbl.ReadList();

        tblProductSubGroupCollection productSubGrpTbl = new tblProductSubGroupCollection();

        for (int i = 0; i < productMainGrpTbl.Count; i++)
        {
            if (productMainGrpTbl[i].subGroup == "0")
                companyStr += "<h4>"+ productMainGrpTbl[i].groupName + "</h4>" +
                    "<ul><li><a href='product-category.aspx?mainCat=" + productMainGrpTbl[i].id + "'>" + productMainGrpTbl[i].groupName + "</a></li></ul>";
            else
            {
                companyStr += "<h4 main-cat='" + productMainGrpTbl[i].id + "' class='main-cat'>" + productMainGrpTbl[i].groupName + "</h4>";
                productSubGrpTbl.ReadList(Criteria.NewCriteria(tblProductSubGroup.Columns.idGroup, CriteriaOperators.Equal,productMainGrpTbl[i].id));

                companyStr += "<ul sub-cat='"+ productMainGrpTbl[i].id + "' class='sub-cat-menu'>";
                for (int j = 0; j < productSubGrpTbl.Count; j++)
                    companyStr += "<li><a href='product-category.aspx?subCat=" + productSubGrpTbl[j].id + "'>" + productSubGrpTbl[j].subGrpName + "</a></li>";
                companyStr += "</ul>";
            }
        }

        productMenuHtml.InnerHtml = companyStr;



        #endregion
    }
}
