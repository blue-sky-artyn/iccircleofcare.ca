using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using bluesky.artyn;
using Cruder.Core;

public partial class Default2 : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        tblProductCollection productTbl = new tblProductCollection();
        tblProductDetailsCollection productDetTbl = new tblProductDetailsCollection();

        tblProductGroupCollection productMainGroupTbl = new tblProductGroupCollection();
        tblProductSubGroupCollection productSubGroupTbl = new tblProductSubGroupCollection();
        
        string productStr = string.Empty;int counter = 0;

        #region Get item from url

        int productCode = 0;
        if (Request.QueryString["productCode"] != null)
        {
            productCode = int.Parse(Request.QueryString["productCode"]);
            productTbl.ReadList(Criteria.NewCriteria(tblProduct.Columns.id, CriteriaOperators.Equal, productCode));
            productDetTbl.ReadList(Criteria.NewCriteria(tblProductDetails.Columns.productId, CriteriaOperators.Equal, productCode));
        }
        else
            Response.Redirect("404.aspx");

        #endregion

        #region titles

        productMainGroupTbl.ReadList(Criteria.NewCriteria(tblProductGroup.Columns.id, CriteriaOperators.Equal, productTbl[0].productGrpId));
        if (productMainGroupTbl[0].subGroup == "1")
            productSubGroupTbl.ReadList(Criteria.NewCriteria(tblProductSubGroup.Columns.idGroup, CriteriaOperators.Equal, productMainGroupTbl[0].id));

        if (productMainGroupTbl.Count == 1)
        {
            titleBigHtml.InnerText = productTbl[0].productName;
            titleSmallHtml.InnerText = productMainGroupTbl[0].groupName;
            if (productSubGroupTbl.Count > 0)
                titleSmall2Html.InnerText += productSubGroupTbl[0].subGrpName;
        }

        #endregion

        #region product pictures

        mainPicHtml.InnerHtml = "<img src='" + productTbl[0].productCoverPicAdd + productTbl[0].productCoverPicName + "' alt='" + productTbl[0].productName + "' class='img-responsive'>" +
                                "<div class='magnifier'><a rel='prettyPhoto[inline]' href='" + productTbl[0].productCoverPicAdd + productTbl[0].productCoverPicName + "' title='" + productTbl[0].productName + "'>" +
                                "<i class='fa fa-play-circle-o' aria-hidden='true'></i></a></div>";

        #region additinal pictures

        tblProductPicsCollection productSubPicTbl = new tblProductPicsCollection();
        productSubPicTbl.ReadList(Criteria.NewCriteria(tblProductPics.Columns.productId, CriteriaOperators.Equal, productTbl[0].id));

        productStr += "<div class='row'>";

        for (int i = 0; i < productSubPicTbl.Count; i++)
        {
            if (counter == 3)
                productStr += "</div><div class='sub-pic-row row-space row'>";

            productStr += "<div class='col-md-4 col-sm-4 col-xs-4'><div class='image-wrap entry'>" +
                                "<img src='"+ productSubPicTbl[i].picAddr + productSubPicTbl[i].picName + "' alt='" + productTbl[0].productName + "' class='img-responsive'>" +
                                "<div class='magnifier'><a rel='prettyPhoto[inline]' href='" + productSubPicTbl[i].picAddr + productSubPicTbl[i].picName + "' title='" + productTbl[0].productName + "'>" +
                                "<i class='fa fa-play-circle-o' aria-hidden='true'></i></a></div>" +
                                "</div></div>";
            counter++;
        }
        productStr += "</div>";

        productSubPicHtml.InnerHtml = productStr;

        #endregion

        #endregion

        #region product details

        productDetailsHtml.InnerHtml = productTbl[0].productDet;
        if (productDetTbl.Count > 0)
            productDetailsHtml.InnerHtml += "<div class='product-code'><p>Product #: " + productDetTbl[0].productCode + "</p></div>";
        ProductPriceHtml.InnerHtml = "Price $" + productTbl[0].productPrice.ToString() + " <span class='unique-item'>each</span>";

            #region group details (tab1)

            //Tab 1
            home.InnerHtml = "<p>" + productMainGroupTbl[0].groupDetail + "</p>";
            home.InnerHtml += "<p>" + productSubGroupTbl[0].subGrpDetails + "</p>";

        #endregion

            #region product spec (tab2)

            //Tab 2
            productStr = "";
            tblProductSpecCollection productSpecTbl = new tblProductSpecCollection();
            productSpecTbl.ReadList(Criteria.NewCriteria(tblProductSpec.Columns.productId, CriteriaOperators.Equal, productTbl[0].id));

            for (int i = 0; i < productSpecTbl.Count; i++)
            {
                productStr += "<tr><td><strong>"+ productSpecTbl[i].specTitle + "</strong></td><td>" + productSpecTbl[i].specDet + "</td></tr>";
                
            }

            techDetHtml.InnerHtml = productStr;

            #endregion

            #region product review/tag (tab3)

            //Tab 3


            #endregion

        #endregion

        #region related products

        productStr = "";
        if (productSubGroupTbl.Count > 0)
            productTbl.ReadList(Criteria.NewCriteria(tblProduct.Columns.productSubGrpId, CriteriaOperators.Equal, productTbl[0].productSubGrpId));
        else
            productTbl.ReadList(Criteria.NewCriteria(tblProduct.Columns.productGrpId, CriteriaOperators.Equal, productTbl[0].productGrpId));

        int step = 0;
        if (productTbl.Count > 4)
            step = 4;
        else
            step = productTbl.Count;

        Random ran = new Random();

        for (int i = 0; i < step; i++)
        {
            int ranNext = ran.Next(0, step);
            productStr += "<div class='col-md-3'><div class='course-box shop-wrapper'>" +
                          "<div class='image-wrap entry'><img src='" + productTbl[ranNext].productCoverPicAdd + productTbl[ranNext].productCoverPicName + "' alt='" + productTbl[ranNext].productName + "' class='img-responsive'></div>" +
                          "<div class='course-details shop-box text-center'><h4>" +
                          "<a href='product-details.aspx?productCode=" + productTbl[ranNext].id + "' title='" + productTbl[ranNext].productName + "'>" + productTbl[ranNext].productName + "</a>" +
                          "<small>" + productMainGroupTbl[0].groupName + "</small>" +
                          "</h4></div></div></div>";
        }

        relatedProductHtml.InnerHtml = productStr;

        #endregion
    }
}