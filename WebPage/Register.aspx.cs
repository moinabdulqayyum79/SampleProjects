using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Threading;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace WebPage
{
    public partial class Register : System.Web.UI.Page
    {

        SqlConnection conn = new SqlConnection
            (System.Configuration.ConfigurationManager.ConnectionStrings["WebPageDBConnectionString"].ConnectionString);
        SqlConnection conn2 = new SqlConnection
            (System.Configuration.ConfigurationManager.ConnectionStrings["WebPageDBConnectionString"].ConnectionString);
        public static bool registered = false;
        protected void Button1_Click(object sender, EventArgs e)
        {
            

            string fName = FNametxt.Text;
            string lName = LNametxt.Text;
            string email = Emailtxt.Text;
            string password = Passwordtxt.Text;
            string query1 = "insert into Users (FirstName,LastName,Email,Password) " +
                "Values( @fName, @lName, @email , @password)";
            string query2 = "select * from Users where Email=@email";
            try
            {
                SqlCommand cmnd2 = new SqlCommand(query2, conn);
                cmnd2.Parameters.AddWithValue("@email", email);
                conn.Open();
                SqlDataReader sdr = cmnd2.ExecuteReader();
                if (sdr.Read())
                {
                    Message.Text = "Email already registered";
                    
                }
                else
                {
                    conn.Close();
                    conn.Dispose();
                    
                    
                    SqlCommand cmnd = new SqlCommand(query1, conn2);
                    cmnd.Parameters.AddWithValue("@fName", fName);
                    cmnd.Parameters.AddWithValue("lName", lName);
                    cmnd.Parameters.AddWithValue("@email", email);
                    cmnd.Parameters.AddWithValue("@password", password);
                    conn2.Open();
                    cmnd.ExecuteNonQuery();
                    Message.Text = "Registration Successfully Completed. Please Login again";
                    registered = true;
                }
                
            }
            catch (Exception ex)
            {
                Message.Text = ex.Message;
            }
            finally
            {
                conn2.Close();
            }
            if (registered)
            {
                Response.Redirect("Login.aspx");
            }
            
        }

        protected void Page_Load(object sender, EventArgs e)
        {
            registered = false;
        }

        protected void Button2_Click(object sender, EventArgs e)
        {

            
            Response.Redirect("Login.aspx");
        }
    }
}