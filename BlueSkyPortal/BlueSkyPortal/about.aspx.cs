using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using bluesky.artyn;
using Cruder.Core;

public partial class about : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        tblCompanyCollection companyTbl = new tblCompanyCollection();
        companyTbl.ReadList();

        if (companyTbl.Count > 0)
        {
            aboutHtml.InnerHtml = companyTbl[0].CoDetail;
        }

    }
}