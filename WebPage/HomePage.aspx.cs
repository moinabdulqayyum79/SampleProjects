using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace WebPage
{
    public partial class HomePage : System.Web.UI.Page
    {
        SqlConnection conn = new SqlConnection
            (System.Configuration.ConfigurationManager.ConnectionStrings["WebPageDBConnectionString"].ConnectionString);
        DataTable dt = new DataTable();
        public static int productId;
        
        protected void Page_Load(object sender, EventArgs e)
        {
            Nametxt.Text = "Welcome " + Login.fname + " " + Login.lname;
            string query =
                "select ProductName,Category,Brand,Price from Products";

            try
            {
                SqlCommand cmnd = new SqlCommand(query, conn);
                conn.Open();
                SqlDataAdapter adpt = new SqlDataAdapter(cmnd);

                //DataTable dt = new DataTable();
                adpt.Fill(dt);
                GridView1.DataSource = dt;
                GridView1.DataBind();
            }
            catch (Exception ex)
            {
                Nametxt.Text = ex.Message;

            }
            finally
            {
                conn.Close();
            }


        }

        protected void Button1_Click(object sender, EventArgs e)
        {
            string categoryBox = "";
            string brandBox = "";
            for (int i = 0; i < CategoryCheck.Items.Count; i++)
            {
                if (CategoryCheck.Items[i].Selected)
                {
                    if (categoryBox == "")
                    {
                        categoryBox = "'" + CategoryCheck.Items[i].Text + "'";
                    }
                    else
                    {
                        categoryBox = categoryBox + "," + "'" + CategoryCheck.Items[i].Text + "'";
                    }
                }
            }

            for (int i = 0; i < CategoryCheck.Items.Count; i++)
            {
                if (BrandCheck.Items[i].Selected)
                {
                    if (brandBox == "")
                    {
                        brandBox = "'" + BrandCheck.Items[i].Text + "'";
                    }
                    else
                    {
                        brandBox = brandBox + "," + "'" + BrandCheck.Items[i].Text + "'";
                    }
                }
            }
            string query="";
            if (categoryBox == "")
            {
                query =
                    "select ProductName,Category,Brand,Price from Products where Brand in (" + brandBox + ")";
            } 
            else if (brandBox == "")
            {
                query =
                    "select ProductName,Category,Brand,Price from Products where Category in (" + categoryBox + ")";
            }
            else
            {
                query =
                    "select ProductName,Category,Brand,Price from Products where Category in (" + categoryBox + ") and Brand in (" + brandBox + ")";
            }
            
            try
            {
                SqlCommand cmnd = new SqlCommand(query, conn);
                conn.Open();
                
                SqlDataAdapter adpt = new SqlDataAdapter(cmnd);
                //DataTable dt = new DataTable();
                dt.Clear();
                adpt.Fill(dt);
                GridView1.DataSource = dt;
                GridView1.DataBind();
            }
            catch (Exception ex)
            {
                Nametxt.Text = ex.Message;

               
            }
            finally
            {
                conn.Close();
            }
            

        }

        protected void GridView1_Sorting(object sender, GridViewSortEventArgs e)
        {

        }

        protected void GridView1_SelectedIndexChanged(object sender, EventArgs e)
        {
            string prodName = GridView1.SelectedRow.Cells[1].Text;
            string brandName= GridView1.SelectedRow.Cells[3].Text;

            string query = "select ProductId from Products where ProductName='" + prodName + "' and Brand='" + brandName + "'";
            SqlCommand cmnd = new SqlCommand(query, conn);
            conn.Open();
            SqlDataReader sdr = cmnd.ExecuteReader();
            sdr.Read();
            productId = Convert.ToInt32(sdr[0].ToString());
            Response.Redirect("ProductDetail.aspx");
            //Nametxt.Text = id.ToString();
        }
    }
}