using System;
using System.Drawing;
using System.Security.Cryptography;
using System.Text;
using System.Windows.Forms;

namespace BasicPasswordGen
{
    public class MainForm : Form
    {
        TextBox txtOut;
        NumericUpDown nudLen;
        CheckBox cbSymbols;

        public MainForm()
        {
            Text = "Password Generator App";
            StartPosition = FormStartPosition.CenterScreen;
            ClientSize = new Size(480, 150);

            var lblLen = new Label { Text = "Length:", AutoSize = true, Location = new Point(16, 18) };
            nudLen = new NumericUpDown { Location = new Point(80, 14), Width = 60, Minimum = 6, Maximum = 64, Value = 12 };

            cbSymbols = new CheckBox { Text = "Include symbols", AutoSize = true, Location = new Point(160, 16), Checked = true };

            var btnGen = new Button { Text = "Generate", Location = new Point(320, 12), Width = 120 };
            btnGen.Click += (_, __) => txtOut.Text = Generate((int)nudLen.Value, cbSymbols.Checked);

            txtOut = new TextBox { Location = new Point(16, 60), Width = 424, ReadOnly = true };
            var btnCopy = new Button { Text = "Copy", Location = new Point(446, 58), Width = 20 };
            btnCopy.Click += (_, __) => { if (!string.IsNullOrEmpty(txtOut.Text)) Clipboard.SetText(txtOut.Text); };

            Controls.AddRange(new Control[] { lblLen, nudLen, cbSymbols, btnGen, txtOut, btnCopy });
        }

        static string Generate(int len, bool includeSymbols)
        {
            const string letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            const string digits = "0123456789";
            const string symbols = "!@#$%^&*()-_=+[]{};:,.<>/?";

            string pool = letters + digits + (includeSymbols ? symbols : "");
            if (string.IsNullOrEmpty(pool)) return string.Empty;

            var bytes = new byte[len];
            using (var rng = RandomNumberGenerator.Create())
                rng.GetBytes(bytes);

            var sb = new StringBuilder(len);
            for (int i = 0; i < len; i++)
                sb.Append(pool[bytes[i] % pool.Length]);

            return sb.ToString();
        }
    }
}
