using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using bluesky.artyn;
using Cruder.Core;

public partial class news_details : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        string newsStr = string.Empty;
        tblNewsDetailsCollection newsDetTbl = new tblNewsDetailsCollection();
        tblNewsGroupCollection newsGrpTbl = new tblNewsGroupCollection();

        tblStaffCollection newsWriterTbl = new tblStaffCollection();

        #region Get item from url

        int newsId = 0; string writerStr = string.Empty;
        if (Request.QueryString["newsId"] != null)
        {
            newsId = int.Parse(Request.QueryString["newsId"]);
            newsDetTbl.ReadList(Criteria.NewCriteria(tblNewsDetails.Columns.id, CriteriaOperators.Equal, newsId));
            newsGrpTbl.ReadList(Criteria.NewCriteria(tblNewsGroup.Columns.id, CriteriaOperators.Equal, newsDetTbl[0].idGroup));
            newsWriterTbl.ReadList(Criteria.NewCriteria(tblStaff.Columns.id, CriteriaOperators.Equal, newsDetTbl[0].idStaffCreator));
            if (newsWriterTbl.Count > 0)
                writerStr = newsWriterTbl[0].StaffName;
            else
                writerStr = "admin";
        }
        else
            Response.Redirect("404.aspx");

        #endregion

        #region titles

        titleSmallHtml.InnerText = newsGrpTbl[0].newsGroupTitle;

        #endregion


        #region place news

        newsStr += "<div class='blog-meta'>" +
               "<small><a>" + newsDetTbl[0].newsDetSubtitle + "</a></small>" +
               "<h3>" + newsDetTbl[0].newsDetTitle + "</h3>" +
               "<ul class='list-inline'><li>" + newsDetTbl[0].newsDetInsertDate + "_" + newsDetTbl[0].newsDetInsertTime + "</li><li><span>written by</span> <a>" + writerStr + "</a></li></ul></div>" +
               "<div class='blog-media'>";

        if (newsDetTbl[0].topPageFileType == 0)
            newsStr += "<img src='" + newsDetTbl[0].topPageFileAddr + "' alt='" + newsDetTbl[0].newsDetTitle + "' class='img-responsive img-rounded'>";
        else if (newsDetTbl[0].topPageFileType == 1)
            newsStr += "<div class='img-responsive img-rounded'><video style='width:100%;'><source src='" + newsDetTbl[0].topPageFileAddr + "' type='video/mp4'>Your browser does not support HTML5 video.</video></div>";
        else
            newsStr += "<div class='img-responsive img-rounded'>" + newsDetTbl[0].topPageFileAddr + "</div>";

        newsStr += "</div><div class='blog-desc-big'>" +
               "<p class='lead'>" + newsDetTbl[0].newsDetGist + "</p>" +
               "<div>" + newsDetTbl[0].newsDetDetails + "</div>" +
               "<hr class='invis'>" +
               //<div class="tags-widget"><ul class="list-inline"><li><a href="#">course</a></li><li><a href="#">web design</a></li><li><a href="#">development</a></li><li><a href="#">language</a></li></ul></div>
               "</div>";

        newsHtml.InnerHtml = newsStr;

        #endregion

        #region simular news
        newsStr = "";
        newsDetTbl.ReadList(Criteria.NewCriteria(tblNewsDetails.Columns.idGroup, CriteriaOperators.Equal, newsGrpTbl[0].id));

        Random ran = new Random();
        int ranNext = ran.Next(0, newsDetTbl.Count);

        //img-circle
        if (newsDetTbl[0].topPageFileType == 0)
            newsStr += "<img src='" + newsDetTbl[0].topPageFileAddr + "' alt='" + newsDetTbl[0].newsDetTitle + "' class='img-responsive img-rounded'>";
        else if (newsDetTbl[0].topPageFileType == 1)
            newsStr += "<div class='img-responsive img-rounded'><video style='width:100%;'><source src='" + newsDetTbl[0].topPageFileAddr + "' type='video/mp4'>Your browser does not support HTML5 video.</video></div>";
        else
            newsStr += "<div class='img-responsive img-rounded'>" + newsDetTbl[0].topPageFileAddr + "</div>";

        newsStr += "<a href='news-details.aspx?newsId=" + newsDetTbl[ranNext].id + "' title='" + newsDetTbl[ranNext].newsDetTitle + "'><h4><span>" + newsDetTbl[ranNext].newsDetTitle + "</span></h4></a>" +
                "<p>" + newsDetTbl[ranNext].newsDetSubtitle + "</p>";

        simularNewsHtml.InnerHtml = newsStr;
        #endregion

        #region recent post

        int limit = 0; newsStr = "";
        newsDetTbl.ReadList();

        if (newsDetTbl.Count > 4)
            limit = newsDetTbl.Count - 4;

        for (int i = newsDetTbl.Count - 1; i >= limit; i--)
        {
            newsStr += "<div class='media'>";

            if (newsDetTbl[i].topPageFileType == 0)
                newsStr += "<img src='" + newsDetTbl[i].topPageFileAddr + "' alt='" + newsDetTbl[i].newsDetTitle + "' class='img-responsive alignleft img-rounded' />";
            else if (newsDetTbl[i].topPageFileType == 1)
                newsStr += "<div class='img-responsive alignleft img-rounded'><video style='width:100%;'><source src='" + newsDetTbl[i].topPageFileAddr + "' type='video/mp4'>Your browser does not support HTML5 video.</video></div>";
            else
                newsStr += "<div class='img-responsive alignleft img-rounded'>" + newsDetTbl[i].topPageFileAddr + "</div>";

            newsStr += "<div class='media-body'>" +
                "<h5 class='mt-0'><a href='news-details.aspx?newsId=" + newsDetTbl[i].id + "' title='" + newsDetTbl[i].newsDetTitle + "'>" + newsDetTbl[i].newsDetTitle + "</a></h5>" +
                "<div class='blog-meta'>" +
                "<ul class='list-inline'><li>" + newsDetTbl[i].newsDetInsertDate + "</li></ul>" +
                "</div></div></div>";
        }

        recentNewsHtml.InnerHtml = newsStr;

        #endregion

    }
}