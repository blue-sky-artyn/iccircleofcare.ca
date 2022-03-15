using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Cruder.Core;
using bluesky.artyn;
public partial class dashboard_login : System.Web.UI.Page
{
    //public tblAdmin CurrentMember
    //{
    //    get
    //    {
    //        if (Session["tblUser"] == null)
    //        {
    //            return null;
    //        }
    //        else return ((tblAdmin)Session["tblUser"]);

    //    }
    //}
    protected void Page_Load(object sender, EventArgs e)
    {
        //if (CurrentMember != null)
        //{
        //    Response.Redirect("admin/default.aspx");
        //}
    }

    protected void btnEnter_Click(object sender, EventArgs e)
    {
        //tblAdmin memberList = tblAdmin.loginCheck(txtUser.Text, txtPass.Text);
        //if (memberList == null)
        //{
        //    lblError.Visible = true;
        //}
        //else
        //{
        //    Session["tblUser"] = memberList;
        //    if (Session["UrlReferrer"] == null)
        //    {
             //   Response.Redirect("default.aspx");
        //    }
        //}




        Response.Redirect("admin/default.aspx");

    }

    protected void btnReg_Click(object sender, EventArgs e)
    { 
        Response.Redirect("register.aspx");
    }
}