const rainbow = {
    vs:`
    varying vec2 vUv;
    uniform vec2 iResolution;
    void main()
    {
    vUv = uv * iResolution;
    vec4 mvPosition = modelViewMatrix * vec4( position, 1.0 );
    gl_Position = projectionMatrix * mvPosition;
    }
    `,
    fs:`
    #include <common>

    #define hue(v)  ( .3 + .3 * cos( 6.3*(v)  + vec4(0,23,21,0)  ) )

    uniform vec2 iResolution;
    uniform float iTime;
    uniform float opacity;
    varying vec2 vUv;

    void mainImage( out vec4 fragColor, in vec2 fragCoord )
    {
        vec2 uv =  floor(fragCoord/iResolution.x * 12.)/12.;    
        fragColor = hue(uv.x + uv.y/3. + iTime*0.5);
        fragColor.a = opacity;
    }

    void main() {
        vec2 st = vUv * iResolution;
        mainImage(gl_FragColor, st);
    }

    `
}

export default rainbow