using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Security.Cryptography;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace WebPage
{
    public partial class ProductDetail : System.Web.UI.Page
    {
        SqlConnection conn = new SqlConnection
            (System.Configuration.ConfigurationManager.ConnectionStrings["WebPageDBConnectionString"].ConnectionString);
        //public static int[] productId = new int[10];
        //public static string[] productName = new string[10];
        //public static int[] productPrice = new int[10];
        //public static int[] quantity = new int[10];
        public static string[,] gridViewArray = new string[10, 4];
        public static int count = 0;
        int priceInt;
        protected void Page_Load(object sender, EventArgs e)
        {
            string query = "select * from Products where ProductId='" + HomePage.productId + "'";
            try
            {
                
                SqlCommand cmnd = new SqlCommand(query, conn);
                
                conn.Open();
                SqlDataReader sdr = cmnd.ExecuteReader();
                sdr.Read();
                
                prodName.Text = sdr[1].ToString();
                category.Text = sdr[2].ToString();
                brand.Text = sdr[3].ToString();
                priceInt = Convert.ToInt32( sdr[4]);
                price.Text = sdr[4].ToString();
                string desc = sdr[5].ToString();
                description.Text = desc.Replace(";", "<br/>");
                
            }
            catch (Exception ex)
            {

                Label l1 = new Label();
                l1.Text = ex.Message;
            }
      
        }

        protected void Button1_Click(object sender, EventArgs e)
        {
            string quantitystr = TextBox1.Text;
            int quantity = Convert.ToInt32(quantitystr);
            bool alrPresent = false;
            for(int i = 0; i < count; i++) { 
                
                if (Convert.ToInt32(gridViewArray[i,0])==HomePage.productId)
                {
                    gridViewArray[i, 2] = (Convert.ToInt32(gridViewArray[i, 2]) + quantity).ToString();
                    gridViewArray[i, 3] = (Convert.ToInt32(gridViewArray[i, 2]) * priceInt).ToString();
                    alrPresent = true;
                    break;
                }
            }
            if (alrPresent==false)
            {
                gridViewArray[count, 0] = HomePage.productId.ToString();
                gridViewArray[count, 1] = prodName.Text;
                
                gridViewArray[count, 2] = quantitystr;
                gridViewArray[count, 3] = (quantity * priceInt).ToString();
                count++;
            }
            

            Response.Redirect("Cart.aspx");
        }

        protected void Button2_Click(object sender, EventArgs e)
        {
            
            
            Response.Redirect("HomePage.aspx");
        }
    }
}