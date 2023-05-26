using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Data.SqlClient;
using System.Collections;
using System.Data;

namespace WebPage
{
    public partial class Cart : System.Web.UI.Page
    {
        SqlConnection conn = new SqlConnection
            (System.Configuration.ConfigurationManager.ConnectionStrings["WebPageDBConnectionString"].ConnectionString);
        protected void Page_Load(object sender, EventArgs e)
        {
            DataTable dt = new DataTable();

            dt.Columns.Add("Product Name", Type.GetType("System.String"));

            dt.Columns.Add("Quantity", Type.GetType("System.String"));

            dt.Columns.Add("Total Price", Type.GetType("System.String"));

           

            for (int i = 0; i < ProductDetail.count; i++)

            {

                dt.Rows.Add();

                dt.Rows[dt.Rows.Count - 1]["Product Name"] = ProductDetail.gridViewArray[i, 1];

                dt.Rows[dt.Rows.Count - 1]["Quantity"] = ProductDetail.gridViewArray[i, 2];

                dt.Rows[dt.Rows.Count - 1]["Total Price"] = ProductDetail.gridViewArray[i, 3];

            }
            GridView1.DataSource = dt;
            GridView1.DataBind();
            int totalPrice=0;
            for (int i = 0; i < ProductDetail.count; i++)
            {
                totalPrice = totalPrice + Convert.ToInt32(ProductDetail.gridViewArray[i, 3]);
            }
            msg.Text = "Total Price is: " + totalPrice;
        }

        protected void Button1_Click(object sender, EventArgs e)
        {
            string query = "INSERT INTO Orders (UserId,TransactionDate) VALUES (@userId,@date)";
            string query2 = "SELECT OrderId FROM Orders WHERE UserId="+Login.userId+" AND TransactionDate='"+DateTime.Now+"'";
            int orderId = 0;
            try
            {
                SqlCommand cmnd = new SqlCommand(query, conn);
                cmnd.Parameters.AddWithValue("@userId", Login.userId);
                cmnd.Parameters.AddWithValue("@date", DateTime.Now);
                conn.Open();
                cmnd.ExecuteNonQuery();
                conn.Close();
                
                SqlCommand cmnd2 = new SqlCommand(query2, conn);
                //cmnd.Parameters.AddWithValue("@userId", Login.userId);
                //cmnd.Parameters.AddWithValue("@date", DateTime.Now);
                conn.Open();
                SqlDataReader sdr = cmnd2.ExecuteReader();
                sdr.Read();
                orderId = Convert.ToInt32(sdr[0]);

            }
            catch (Exception ex)
            {
                Label1.Text = ex.Message;
            }
            finally
            {
                conn.Close();
                
            }
            string query3 = "INSERT INTO OrderLine (OrderId,ProductId,Quantity) VALUES (@orderId,@productId,@quantity)";
            try
            {
                for (int i = 0; i < ProductDetail.count; i++)
                {
                    SqlCommand cmnd3 = new SqlCommand(query3, conn);
                    cmnd3.Parameters.AddWithValue("@orderId", orderId);
                    cmnd3.Parameters.AddWithValue("@productId", ProductDetail.gridViewArray[i, 0]);
                    cmnd3.Parameters.AddWithValue("@quantity", ProductDetail.gridViewArray[i, 2]);
                    conn.Open();
                    cmnd3.ExecuteNonQuery();
                    conn.Close();
                }
            }
            catch (Exception ex)
            {

                Label2.Text = ex.Message;
            }

            Label3.Text = "Order successfully placed";


        }

        protected void Button2_Click(object sender, EventArgs e)
        {
            Response.Redirect("HomePage.aspx");
        }
    }
}