using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using bluesky.artyn;
using Cruder.Core;

public partial class news : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        string newsStr = string.Empty; string writerStr = string.Empty;
        tblNewsDetailsCollection newsTbl = new tblNewsDetailsCollection();
        newsTbl.ReadList();
        tblNewsGroupCollection newsGroupTbl = new tblNewsGroupCollection();



        #region news 

        tblStaffCollection newsWriterTbl = new tblStaffCollection();

        for (int i = 0; i < newsTbl.Count; i++)
        {
            newsGroupTbl.ReadList(Criteria.NewCriteria(tblNewsGroup.Columns.id, CriteriaOperators.Equal, newsTbl[i].idGroup));
            newsWriterTbl.ReadList(Criteria.NewCriteria(tblStaff.Columns.id, CriteriaOperators.Equal, newsTbl[i].idStaffCreator));
            if (newsWriterTbl.Count > 0)
                writerStr = newsWriterTbl[0].StaffName;
            else
                writerStr = "admin";

            newsStr += "<div class='content blog-list'><div class='blog-wrapper clearfix'><div class='blog-meta'>" +
                "<small><a href='#'>" + newsGroupTbl[0].newsGroupTitle + "</a></small>" +
                "<h3><a href='news-details.aspx?newsId=" + newsTbl[i].id + "' title='" + newsTbl[i].newsDetTitle + "'>" + newsTbl[i].newsDetTitle + "</a></h3>" +
                "<ul class='list-inline'><li>" + newsTbl[i].newsDetInsertDate + "_" + newsTbl[i].newsDetInsertTime + "</li><li><span>written by</span> <a href='#'>" + writerStr + "</a></li></ul></div><div class='blog-media'>" +
                "<a href='news-details.aspx?newsId=" + newsTbl[i].id + "' title='" + newsTbl[i].newsDetTitle + "'>";

            if (newsTbl[i].topPageFileType == 0)
                newsStr += "<img src='" + newsTbl[i].topPageFileAddr + "' alt='" + newsTbl[i].newsDetTitle + "' class='img-responsive img-rounded'>";
            else if (newsTbl[i].topPageFileType == 1)
                newsStr += "<div class='img-responsive img-rounded'><video style='width:100%;'><source src='" + newsTbl[i].topPageFileAddr + "' type='video/mp4'>Your browser does not support HTML5 video.</video></div>";
            else
                newsStr += "<div class='img-responsive img-rounded'>" + newsTbl[i].topPageFileAddr + "</div>";

            newsStr += "</a></div><div class='blog-desc-big'>" +
                "<p class='lead'>" + newsTbl[i].newsDetSubtitle + "</p>" +
                "<p class='news-gist'>" + newsTbl[i].newsDetGist + "</p>" +
                //"<p>" + newsTbl[i].newsDetDetails + "</p>" +
                "<a href='news-details.aspx?newsId=" + newsTbl[i].id + "' class='btn btn-primary'>Read More</a></div></div></div>";
        }

        newsHtml.InnerHtml = newsStr;

        #endregion

        #region recent post

        int limit = 0; newsStr = "";
        if (newsTbl.Count > 4)
            limit = newsTbl.Count - 4;
        
        for (int i = newsTbl.Count - 1; i >= limit; i--)
        {
            newsStr += "<div class='media'>";

            if (newsTbl[i].topPageFileType == 0)
                newsStr += "<img src='" + newsTbl[i].topPageFileAddr + "' alt='" + newsTbl[i].newsDetTitle + "' class='img-responsive alignleft img-rounded' />";
            else if (newsTbl[i].topPageFileType == 1)
                newsStr += "<div class='img-responsive alignleft img-rounded'><video style='width:100%;'><source src='" + newsTbl[i].topPageFileAddr + "' type='video/mp4'>Your browser does not support HTML5 video.</video></div>";
            else
                newsStr += "<div class='img-responsive alignleft img-rounded'>" + newsTbl[i].topPageFileAddr + "</div>";

            newsStr += "<div class='media-body'>" +
                "<h5 class='mt-0'><a href='news-details.aspx?newsId=" + newsTbl[i].id + "'>" + newsTbl[i].newsDetTitle + "</a></h5>" +
                "<div class='blog-meta'>" +
                "<ul class='list-inline'><li>" + newsTbl[i].newsDetInsertDate + "</li></ul>" +
                "</div></div></div>";
        }

        recentNewsHtml.InnerHtml = newsStr;

        #endregion
    }
}