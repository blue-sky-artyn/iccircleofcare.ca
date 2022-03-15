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
    public tblAdmin CurrentMember
    {
        get
        {
            if (Session["tblUser"] == null)
            {
                return null;
            }
            else return ((tblAdmin)Session["tblUser"]);

        }
    }
    protected void Page_Load(object sender, EventArgs e)
    {
        if (CurrentMember != null)
        {
            Response.Redirect("admin/default.aspx");
        }
    }

    protected void btnEnter_Click(object sender, EventArgs e)
    {
        bool flag = true;
        tblSubscribers membersTbl = new tblSubscribers();

        if (txtEmail.Text.Trim().Length > 0 && txtPass1.Text.Trim().Length > 0 && txtPass2.Text.Trim().Length > 0 && gridCheck.Checked)
        {
            membersTbl.planId = 1;
            membersTbl.UserName = txtEmail.Text;
            membersTbl.UserFirstName = txtName.Text;
            membersTbl.UserFamily = txtFamily.Text;
            if (txtPass1.Text == txtPass2.Text)
                membersTbl.UserPass = txtPass1.Text;
            else
            {
                flag = false;
                txtError.InnerText = "Passwords are not matched";
                txtError.Visible = true;
            }
            membersTbl.UserInsertDate = DateTime.Now.ToString("yyyyMMdd");
            membersTbl.UserPicName = "";
            membersTbl.UserPicAddr = "";
            membersTbl.UserDetail = txtDetails.Text;
            membersTbl.UserStartDate = DateTime.Now.ToString("yyyyMMdd");
            membersTbl.UserStartTime = DateTime.Now.ToString("hh:mm:ss");
            membersTbl.UserEndDate = "0";
            membersTbl.UserEndTime = "";
            membersTbl.UserEmail = txtEmail.Text;
            membersTbl.UserTel = txtTel.Text;
            membersTbl.UserAddress = txtAddr.Text;
            membersTbl.allow = "1";
            if (flag)
            {
                membersTbl.Create();
                Response.Redirect("login.aspx?itemMail=" + txtEmail.Text);
            }
        }
        else
            txtError.Visible = true;   
    }
}