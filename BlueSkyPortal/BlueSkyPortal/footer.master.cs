using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using Cruder.Core;
using bluesky.artyn;

public partial class footer : System.Web.UI.MasterPage
{
    protected void Page_Load(object sender, EventArgs e)
    {

    }
    protected void btnRegister_Click(object sender, EventArgs e)
    {
        tblMemberOfDailyEmailCollection subscribersRepeatCheckTbl = new tblMemberOfDailyEmailCollection();

        if (txtRegister.Value.Trim().Length > 0)
        {
            subscribersRepeatCheckTbl.ReadList(Criteria.NewCriteria(tblMemberOfDailyEmail.Columns.memberEmail, CriteriaOperators.Like, txtRegister.Value.Trim()));
            if (subscribersRepeatCheckTbl.Count > 0)
            {
                lblErrorSubscriptors.InnerText = "This email has been already registered.";
            }
            else
            {
                tblMemberOfDailyEmail subscribersTbl = new tblMemberOfDailyEmail();

                subscribersTbl.memberName = "";
                subscribersTbl.memberSurname = "";

                subscribersTbl.memberEmail = txtRegister.Value.Trim();
                subscribersTbl.memberInsDate = DateTime.Now.ToString("yyyy/MM/dd");
                subscribersTbl.memberExpDate = "0";
                subscribersTbl.memberRequestToDea = "0";
                subscribersTbl.allow = "1";

                subscribersTbl.Create();


                lblErrorSubscriptors.InnerText = "Your email has been added to daily news letter of Decowall inc.";
            }
        }

    }
}
