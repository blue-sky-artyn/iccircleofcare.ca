using System;
using System.Activities.Expressions;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using bluesky.artyn;
using Cruder.Core;

public partial class product_category : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        tblProductGroupCollection productMainGroupTbl = new tblProductGroupCollection();
        tblProductSubGroupCollection productSubGroupTbl = new tblProductSubGroupCollection();
        tblProductCollection productTbl = new tblProductCollection();
        tblProductDetailsCollection productDetTbl = new tblProductDetailsCollection();


        #region Get data from url

        int mainCat = 0;int subCat = 0;int pageNo = 0;
        if (Request.QueryString["mainCat"] != null)
        {
            mainCat = int.Parse(Request.QueryString["mainCat"]);
            //read data for title
            productMainGroupTbl.ReadList(Criteria.NewCriteria(tblProductGroup.Columns.id, CriteriaOperators.Equal, mainCat));
            productTbl.ReadList(Criteria.NewCriteria(tblProduct.Columns.productGrpId, CriteriaOperators.Equal, mainCat));
        }
        else if (Request.QueryString["subCat"] != null)
        {
            subCat = int.Parse(Request.QueryString["subCat"]);
            //read data for title
                productSubGroupTbl.ReadList(Criteria.NewCriteria(tblProductSubGroup.Columns.id, CriteriaOperators.Equal, subCat));
                productMainGroupTbl.ReadList(Criteria.NewCriteria(tblProductGroup.Columns.id, CriteriaOperators.Equal, productSubGroupTbl[0].idGroup));
            productTbl.ReadList(Criteria.NewCriteria(tblProduct.Columns.productSubGrpId, CriteriaOperators.Equal, subCat));
        }
        else
        {
            productMainGroupTbl.ReadList();
            productTbl.ReadList();
        }

        if (Request.QueryString["page"] != null)
        {
            pageNo = Convert.ToInt32(Request.QueryString["page"]);
            pageNo = pageNo * 12;
        }
        #endregion

        #region titles


        if (productMainGroupTbl.Count == 1)
        {
            titleBigHtml.InnerText = productMainGroupTbl[0].groupName;
            if (productSubGroupTbl.Count == 1)
                titleSmallHtml.InnerText = productSubGroupTbl[0].subGrpName;
        }
        else
        {
            titleBigHtml.InnerText = "Available opportunities to Donate";
            titleSmallHtml.InnerText = "All opportunities";
        }

        #endregion

        #region number of products

        if (productTbl.Count >= 12)
        {
            if ((pageNo + 12) > productTbl.Count)
                productAmountHtml.InnerText = "Showing " + pageNo + "–" + productTbl.Count + " of " + productTbl.Count + " results";
            else
                productAmountHtml.InnerText = "Showing " + pageNo + "–" + (pageNo + 12) + " of " + productTbl.Count + " results";
        }
        else if (productTbl.Count > 0)
            productAmountHtml.InnerText = "Showing 1–" + productTbl.Count + " of " + productTbl.Count + " results";
        else
            productAmountHtml.InnerText = "There is no item to show";

        #endregion

        #region filling items

        string productStr = string.Empty;int minLevel = 0;

        if (productTbl.Count - pageNo - 12 > 0)
            minLevel = productTbl.Count - pageNo - 12;

        if (productTbl.Count >= 12)
            for (int i = productTbl.Count - 1 - pageNo; i >= minLevel; i--)
            {
                productSubGroupTbl.ReadList(Criteria.NewCriteria(tblProductSubGroup.Columns.id, CriteriaOperators.Equal, productTbl[i].productSubGrpId));
                productMainGroupTbl.ReadList(Criteria.NewCriteria(tblProductGroup.Columns.id, CriteriaOperators.Equal, productTbl[i].productGrpId));
                productDetTbl.ReadList(Criteria.NewCriteria(tblProductDetails.Columns.productId, CriteriaOperators.Equal, productTbl[i].id));

                productStr += "<div class='col-md-3'><div class='course-box shop-wrapper'><div class='image-wrap entry'><img src='" + productTbl[i].productCoverPicAdd + productTbl[i].productCoverPicName + "' alt='" + productTbl[i].productName + "' class='img-responsive'>" +
                           "<a href='product-details.aspx?productCode=" + productTbl[i].id + "' title='" + productTbl[i].productName + "'></a></div>" +
                           "<div class='course-details shop-box text-center'><h4><a href='product-details.aspx?productCode=" + productTbl[i].id + "' title='" + productTbl[i].productName + "'>" + productTbl[i].productName + "</a><small>" + productMainGroupTbl[0].groupName;
                if (productSubGroupTbl.Count > 0)
                    productStr += "/" + productSubGroupTbl[0].subGrpName;

                productStr += "</small></h4></div>";
                if (productDetTbl.Count > 0)
                    productStr += "<div class='product-code'><p>Product #: " + productDetTbl[0].productCode + "</p></div>";

                productStr += "<div class='course-footer clearfix'><div class='pull-left'><ul class='list-inline'>" +
                           "<li><a href='product-details.aspx?itemGet=" + productTbl[i].id + "'><i class='fa fa-shopping-basket'></i> Add Cart</a></li></ul></div>" +
                           "<div class='pull-right'><ul class='list-inline'><li><a href='product-details.aspx?productCode=" + productTbl[i].id + "'>$" + productTbl[i].productPrice + ".00</a></li></ul></div></div></div></div>";
            }
        else
            for (int i = productTbl.Count - 1; i >= 0; i--)
            {
                productSubGroupTbl.ReadList(Criteria.NewCriteria(tblProductSubGroup.Columns.id, CriteriaOperators.Equal, productTbl[i].productSubGrpId));
                productMainGroupTbl.ReadList(Criteria.NewCriteria(tblProductGroup.Columns.id, CriteriaOperators.Equal, productTbl[i].productGrpId));
                productDetTbl.ReadList(Criteria.NewCriteria(tblProductDetails.Columns.productId, CriteriaOperators.Equal, productTbl[i].id));

                productStr += "<div class='col-md-3'><div class='course-box shop-wrapper'><div class='image-wrap entry'><img src='" + productTbl[i].productCoverPicAdd + productTbl[i].productCoverPicName + "' alt='" + productTbl[i].productName + "' class='img-responsive'>" +
                           "<a href='product-details.aspx?productCode=" + productTbl[i].id + "' title='" + productTbl[i].productName + "'></a></div>" +
                           "<div class='course-details shop-box text-center'><h4><a href='product-details.aspx?productCode=" + productTbl[i].id + "' title='" + productTbl[i].productName + "'>" + productTbl[i].productName + "</a><small>" + productMainGroupTbl[0].groupName;
                if (productSubGroupTbl.Count > 0)
                    productStr += "/" + productSubGroupTbl[0].subGrpName;

                productStr += "</small></h4></div>";
                if (productDetTbl.Count > 0)
                    productStr += "<div class='product-code'><p>Product #: " + productDetTbl[0].productCode + "</p></div>";

                productStr += "<div class='course-footer clearfix'><div class='pull-left'><ul class='list-inline'>" +
                           "<li><a href='product-details.aspx?itemGet=" + productTbl[i].id + "'><i class='fa fa-shopping-basket'></i> Add Cart</a></li></ul></div>" +
                           "<div class='pull-right'><ul class='list-inline'><li><a href='product-details.aspx?productCode=" + productTbl[i].id + "'>$";
                if (productTbl[i].productPrice.ToString().IndexOf(".") > 0)
                    productStr += productTbl[i].productPrice + "</a></li></ul></div></div></div></div>";
                else
                    productStr += productTbl[i].productPrice + ".00</a></li></ul></div></div></div></div>";

            }

        productHtml.InnerHtml = productStr;

        #endregion

        #region paging
        string pagingStr = "";
        if (productTbl.Count >= 12)
        {
            int devisionResult = productTbl.Count / 12;

            pagingStr += "<li class='disabled'><a href='javascript:void(0)'>&laquo;</a></li>";
            for (int i = 0; i < devisionResult; i++)
            {
                if (mainCat > 0)
                {
                    pagingStr += "<li><a href='product-category.aspx?mainCat=" + mainCat + "&page=" + i + "'>" + (i + 1) + "</a></li>";
                }
                else if (subCat > 0)
                {
                    pagingStr += "<li><a href='product-category.aspx?subCat=" + subCat + "&page=" + i + "'>" + (i + 1) + "</a></li>";
                }
                else
                {
                    pagingStr += "<li><a href='product-category.aspx?page=" + i + "'>" + (i + 1) + "</a></li>";
                }
            }
            pagingStr += "<li><a href='javascript:void(0)'>&raquo;</a></li>";
        }
        else
        {
            pagingStr = "<li class='disabled'><a href='javascript:void(0)'>&laquo;</a></li>"+
                                "<li class='active'><a href='javascript:void(0)'>1</a></li>"+
                                "<li><a href='javascript:void(0)'>&raquo;</a></li>";
        }
        pagingHtml.InnerHtml = pagingStr;

        #endregion
    }
}