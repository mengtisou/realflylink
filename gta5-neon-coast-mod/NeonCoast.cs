// Neon Coast - an original GTA V script mod with a "next-gen Florida vibe".
// Requires: Script Hook V + Script Hook V .NET (v3). Single-player only.
using System;
using System.Drawing;
using System.Windows.Forms;
using GTA;
using GTA.Math;
using GTA.UI;

public class NeonCoast : Script
{
    // ---- settings ----
    const Keys KeyGoldenHour = Keys.F7;   // lock sunset + clear weather
    const Keys KeyNeon       = Keys.F8;   // neon underglow on current vehicle
    const Keys KeySpawn      = Keys.F9;   // spawn a random sports car
    const Keys KeyPhone      = Keys.F10;  // toggle follower-counter HUD

    static readonly string[] Cars = { "ZENTORNO", "ITALIGTB", "TURISMOR", "NEON", "JESTER", "COMET2" };
    static readonly Color[] NeonColors =
    {
        Color.FromArgb(255, 0, 170), Color.FromArgb(0, 230, 255),
        Color.FromArgb(160, 80, 255), Color.FromArgb(255, 140, 0)
    };

    bool goldenHour, hud;
    int neonIndex, followers = 1000, nextGain;
    readonly Random rng = new Random();

    public NeonCoast()
    {
        Tick += OnTick;
        KeyDown += OnKeyDown;
        Notification.Show("~p~Neon Coast~s~ loaded. F7 sunset, F8 neon, F9 car, F10 HUD.");
    }

    void OnKeyDown(object sender, KeyEventArgs e)
    {
        var ped = Game.Player.Character;

        if (e.KeyCode == KeyGoldenHour)
        {
            goldenHour = !goldenHour;
            if (goldenHour) World.Weather = Weather.ExtraSunny;
            Notification.Show("Golden hour: " + (goldenHour ? "~g~ON" : "~r~OFF"));
        }
        else if (e.KeyCode == KeyNeon && ped.IsInVehicle())
        {
            var v = ped.CurrentVehicle;
            var c = NeonColors[neonIndex++ % NeonColors.Length];
            foreach (VehicleNeonLight l in new[] {
                VehicleNeonLight.Left, VehicleNeonLight.Right,
                VehicleNeonLight.Front, VehicleNeonLight.Back })
                v.Mods.SetNeonLightsOn(l, true);
            v.Mods.NeonLightsColor = c;
        }
        else if (e.KeyCode == KeySpawn)
        {
            var model = new Model(Cars[rng.Next(Cars.Length)]);
            if (!model.Request(2000)) return;
            var pos = ped.Position + ped.ForwardVector * 6f;
            var car = World.CreateVehicle(model, pos, ped.Heading);
            if (car != null) { ped.SetIntoVehicle(car, VehicleSeat.Driver); }
            model.MarkAsNoLongerNeeded();
        }
        else if (e.KeyCode == KeyPhone)
        {
            hud = !hud;
        }
    }

    void OnTick(object sender, EventArgs e)
    {
        if (goldenHour)
            World.CurrentTimeOfDay = new TimeSpan(18, 30, 0); // fixed sunset

        if (hud)
        {
            // Fun fake "followers" counter that grows as you drive fast / cause chaos.
            if (Game.GameTime > nextGain)
            {
                nextGain = Game.GameTime + 2000;
                var ped = Game.Player.Character;
                if (ped.IsInVehicle() && ped.CurrentVehicle.Speed > 25f)
                    followers += rng.Next(5, 40);
            }
            new TextElement("Followers: " + followers.ToString("N0"),
                new PointF(20f, 20f), 0.5f, Color.FromArgb(255, 0, 170)).Draw();
        }
    }
}
