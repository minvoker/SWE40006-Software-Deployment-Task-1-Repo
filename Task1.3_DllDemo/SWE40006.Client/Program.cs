using System;
using SWE40006.MathLib;
using SWE40006.TextLib;

namespace SWE40006.Client
{
    class Program
    {
        static void Main()
        {
            long a = 10, b = 25;
            long sum = MathOps.Add(a, b);

            Console.WriteLine(Formatter.FormatSum(a, b, sum)); // "10 + 25 = 35"
            Console.WriteLine(Formatter.Shout("dlls shout"));
            Console.WriteLine("Press any key to exit!");
            Console.ReadKey();
        }
    }
}
