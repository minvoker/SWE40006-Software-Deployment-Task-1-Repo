using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SWE40006.TextLib
{
    public static class Formatter
    {
        public static string FormatSum(long a, long b, long sum)
            => $"{a} + {b} = {sum}";
        public static string Shout(string s)
            => (s ?? "").ToUpperInvariant();
    }
}
