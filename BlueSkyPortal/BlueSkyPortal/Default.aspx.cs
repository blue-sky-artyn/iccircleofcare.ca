using System;
using System.Collections.Generic;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using bluesky.artyn;
using System.Xml.Linq;
using Cruder.Core;
using System.Linq;
using System.Web.Services.Description;

public partial class _Default : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        int dateNow = Convert.ToInt32(DateTime.Now.ToString("yyyyMMdd"));
        string timeNow = DateTime.Now.ToString("hh:mm:ss");

        string htmlString = string.Empty;

        #region Slider

        string sliderStr = string.Empty;
        tblSliderCollection sliderTbl = new tblSliderCollection();
        sliderTbl.ReadList();

        for (int i = 0; i < sliderTbl.Count; i++)
        {
                sliderStr += "<li><img src='" + sliderTbl[i].SliderPicAddr + sliderTbl[i].SliderPicName + "' alt='"+i+"' title='" + sliderTbl[i].SliderTitle + "' id='wows1_"+i+"' /></li>"; 
        }
        //sliderItemsHtml.InnerHtml = sliderStr;

        #endregion

        #region company details

        tblCompanyCollection companyTbl = new tblCompanyCollection();
        companyTbl.ReadList();

        tblCompanyHonorsCollection companyHonorTbl = new tblCompanyHonorsCollection();
        if (companyTbl.Count > 0)
            companyHonorTbl.ReadList(Criteria.NewCriteria(tblCompanyHonors.Columns.idCompany, CriteriaOperators.Equal, companyTbl[0].id));

        if (companyTbl.Count > 0)
        {
            //companyWordHtml.InnerHtml = "<p>Decowall inc. (Buliding materials)</p>" +
            //                            "<small>" + companyTbl[0].CoOwnerWord + "</small>";
            if (companyHonorTbl.Count > 0)
            {
                //honorPicHtml.Src = companyHonorTbl[0].HonorPicAddr + companyHonorTbl[0].HonorPicName;
                //honorPicHtml.Alt = companyHonorTbl[0].HonorTitle;

                //aboutCompanyHtml.InnerHtml = "<h2>" + companyHonorTbl[0].HonorTitle + "</h2>";
                //aboutCompanyHtml.InnerHtml += companyHonorTbl[0].HonorDetails;
            }
        }

        #endregion

        #region page elements

        tblLandingPageElementsCollection elementsTbl = new tblLandingPageElementsCollection();
        elementsTbl.ReadList();

        if (elementsTbl.Count > 0)
        {
            //parallaxImg.Src = elementsTbl[0].picAddr + elementsTbl[0].picName;
            //parallaxImg.Alt = "Decowall inc " + elementsTbl[0].picName;
        }
        
        if (elementsTbl.Count > 2)
        { 
            //sectionInfoHtml.Attributes.Add("style", "background-image: url(" + elementsTbl[2].picAddr + elementsTbl[2].picName + ");");
        }


        #endregion

        #region Rss news
        string newsString = "";
        string RssFeedUrl;
        tblNewsRssCollection rssNewsTbl = new tblNewsRssCollection();
        rssNewsTbl.ReadList();

        for (int i = 0; i < rssNewsTbl.Count; i++)
        {
            if (rssNewsTbl[i].RssLink.Trim().Length > 3)
            {
                RssFeedUrl = rssNewsTbl[i].RssLink;

                newsString += PopulateRssFeed(RssFeedUrl);
            }
        }

        //rssHtml.InnerHtml = newsString;
        #endregion

        #region Information
        htmlString = "<div class='row'>";int counter = 0;
        tblInformationDetailCollection informationTbl = new tblInformationDetailCollection();
        informationTbl.ReadList();

        #region content of information section

        for (int i = informationTbl.Count - 1; i >= 0; i--)
        {

            if (counter == 12)
                htmlString += "</div><div class='row'>";


            if (informationTbl[i].infDetailsGist.Length > 100)
            {
                htmlString += "<div class='col-md-3'>";
                counter += 3;
            }
            else
            {
                htmlString += "<div class='col-md-6'>";
                counter += 6;
            }

            htmlString += "<div class='box m30'><i class='fa fa-info-circle' aria-hidden='true'></i>" +
                        "<h4>" + informationTbl[i].infDetailTitle + "</h4>" +
                        "<p>" + informationTbl[i].infDetailsGist + "</p>" +
                        "<a href='information-details.aspx?itemGet=" + informationTbl[i].id + "' class='readmore'>Read more</a></div></div>";
           
            #region cover picture

            //if (informationTbl[i].frontFileType == 0)
            //    newsStr += "<a href='information-details.aspx?itemGet=" + informationTbl[i].id + "'><img src='./images/info/" + informationTbl[i].frontFile + "' alt='TICC " + informationTbl[i].frontFile + "' style='width: 100%;border-radius: 15px 0px 15px 0px;'></a>";
            //else if (informationTbl[0].frontFileType == 1)
            //    newsStr += "<div><a href='information-details.aspx?itemGet=" + informationTbl[i].id + "'><i class='video-icon fa fa-video-camera' aria-hidden='true'></i><video style='width: 100%;border-radius: 15px 0px 15px 0px;'><source src='../movie/info/" + informationTbl[i].frontFile + "' type='video/mp4'>Your browser does not support HTML5 video.</video></a></div>";
            //else
            //    newsStr += informationTbl[i].frontFile;

            #endregion

        }
        htmlString += "</div>";

        #endregion

        //inforamtionHtml.InnerHtml = htmlString;
        #endregion

        #region services

        string serviceStr = string.Empty;
        tblServicesCollection serviceTbl = new tblServicesCollection();
        serviceTbl.ReadList();

        tblServiceGroupCollection serviceGroupTbl = new tblServiceGroupCollection();
        serviceGroupTbl.ReadList();

        for (int i = 0; i < serviceGroupTbl.Count; i++)
        {
            serviceStr += "<div class='col-md-4'><div class='box testimonial'>" +
                        "<p class='testiname'><strong>" + serviceGroupTbl[i].ServiceGroupIcon +"<span class='title-with-icon'>" + serviceGroupTbl[i].ServiceGroupTitle + "</span></strong></p>" +
                        "<p>" + serviceGroupTbl[i].ServiceGroupDetail + "</p>" +
                        "</div></div>";
        }

        //servicesHtml.InnerHtml = serviceStr;

        #endregion

        #region news
        htmlString = "";
        int tempDateShow = 0; int tempDateExp = 0; counter = 0;
        tblNewsDetailsCollection newsTbl = new tblNewsDetailsCollection();
        newsTbl.ReadList();

        tblNewsGroupCollection newsGrpTbl = new tblNewsGroupCollection();

        htmlString += "<div class='row'>";
        for (int i = 0; i < newsTbl.Count; i++)
        {
            newsGrpTbl.ReadList(Criteria.NewCriteria(tblNewsGroup.Columns.id, CriteriaOperators.Equal, newsTbl[i].idGroup));
            tempDateShow = Convert.ToInt32(newsTbl[i].newsDetStartDate.Substring(0, 4) + newsTbl[i].newsDetStartDate.Substring(5, 2) + newsTbl[i].newsDetStartDate.Substring(8, 2));
            tempDateExp = Convert.ToInt32(newsTbl[i].newsDetEndDate.Substring(0, 4) + newsTbl[i].newsDetEndDate.Substring(5, 2) + newsTbl[i].newsDetEndDate.Substring(8, 2));


            if (tempDateShow <= dateNow && tempDateExp >= dateNow)
            {
                if (counter == 3)
                {
                    htmlString += "</div><div class='row' style='margin-top: 15px;'>";
                    counter = 0;
                }

                htmlString += "<div class='col-lg-4 col-md-12'>" +
                        "<div class='blog-box'><div class=''><img src='" + newsTbl[i].topPageFileAddr + "' alt='" + newsTbl[i].newsDetTitle + "' class='img-responsive'>" +
                        "<div class='magnifier'><a href='news-details.aspx?newsId=" + newsTbl[i].id + "' title='" + newsTbl[i].newsDetTitle + "'><i class='flaticon-add'></i></a></div></div><div class='blog-desc'>" +
                        "<h4><a href='news-details.aspx?newsId=" + newsTbl[i].id + "'>" + newsTbl[i].newsDetTitle + "</a></h4>" +
                        "<p>" + newsTbl[i].newsDetGist + "</p>" +
                        "</div><div class='post-meta'>" +
                        "<ul class='list-inline'><li><a href='news-details.aspx?newsId=" + newsTbl[i].id + "'>" + newsTbl[i].newsDetInsertDate + "</a></li><li><a href='news-details.aspx?newsId=" + newsTbl[i].id + "'>" + newsGrpTbl[0].newsGroupTitle + "</a></li></ul></div></div></div>";

                counter++;
            }

        }

        htmlString += "</div>";



        //newsDetHtml.InnerHtml = htmlString;

        #endregion

        #region special offer
        string popPageStr = string.Empty;int popUpStartDate = 0; int popUpEndDate = 0;
        tblPopupPageCollection popUpPageTbl = new tblPopupPageCollection();
        popUpPageTbl.ReadList(Criteria.NewCriteria(tblPopupPage.Columns.allow, CriteriaOperators.Like, "1"));

        for (int i = 0; i < popUpPageTbl.Count; i++)
        {
            popUpStartDate = Convert.ToInt32(popUpPageTbl[i].StartDate.Substring(0, 2) + popUpPageTbl[i].StartDate.Substring(3, 2)+ popUpPageTbl[i].StartDate.Substring(6, 4));
            popUpEndDate = Convert.ToInt32(popUpPageTbl[i].EndDate.Substring(0, 2) + popUpPageTbl[i].EndDate.Substring(3, 2) + popUpPageTbl[i].EndDate.Substring(6, 4));

            if (popUpStartDate >= dateNow && popUpEndDate <= dateNow)
            {
                popPageStr += "<a href='"+ popUpPageTbl[i].popupLink + "'><div class='row callout'><div class='col-md-4 text-center'>" +
                    //popUpPageTbl[i].popupPicAddr + popUpPageTbl[i].popupPicAddr
                    //"<h3><sup>$</sup>49.99</h3>" +
                    "<h4>"+ popUpPageTbl[i].popupTitle + "</h4></div>" +
                    "<div class='col-md-8'><p class='lead'>"+ popUpPageTbl[i].popupDetails + "</p></div></div></a>";
            }

        }
        //popUpHtml.InnerHtml = popPageStr;
        #endregion

    }


    private string PopulateRssFeed(string rssLink)
    {
        string RssFeedUrl = rssLink;
        try
        {
            int counter = 1;
            string newsString = "";
            XDocument xDoc = new XDocument();
            xDoc = XDocument.Load(RssFeedUrl);
            var items = (from x in xDoc.Descendants("item")
                         select new
                         {
                             //title of RSS
                             title = x.Element("title").Value,
                             //link to page
                             link = x.Element("link").Value,
                             //published date
                             pubDate = x.Element("pubDate"),
                             //details of RSS
                             description = x.Element("description").Value,
                             //picture
                             enclosure = x.Element("enclosure").Value    
                         });

            if (items != null)
            {
                foreach (var i in items)
                {
                    newsString += "<div class='card'>";
                    if (i.enclosure.Trim().Length > 0)
                    {
                        newsString += "<img class='card-img-top' src='" + i.enclosure + "' alt='TICC company'>";
                    }

                    newsString += "<div class='card-body'>" +
                            "<h5 class='card-title'>" + i.title + "</h5>" +
                            "<p class='card-text'>" + i.description + "</p>" +
                            "<a href='" + i.link + "' class='btn-rss'>Read more</a></div></div>";

                }
                newsString += "</div>";

            }
            return newsString;
        }
        catch (Exception ex)
        {
            string newsString = "error is ( " + ex.ToString() + " )";
            return newsString;
        }
    }

}