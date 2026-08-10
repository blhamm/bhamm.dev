import { load } from '@apple/mapkit-loader';

window.guestbookMap = function (points) {
    return {
        map: null,
        observer: null,
        visibilityObserver: null,
        allAnnotations: [],
        showSignees: true,
        showVisitors: true,

        async init() {
            const el = this.$refs.map;
            const meta = document.querySelector('meta[name="apple-mapkit-token"]');
            const token = meta ? meta.content : null;

            if (!token) {
                console.error('Apple MapKit token meta tag not found');
                return;
            }

            try {
                await load({ 
                    token,
                    libraries: ['map', 'annotations']
                });
                const mapkit = window.mapkit;

                this.applyThemeStyles = (isDark) => {
                    if (!this.map) return;
                    
                    const waterColor = isDark ? "#292D3E" : "#fefefe";
                    this.map.colorScheme = isDark ? mapkit.ColorScheme.Dark : mapkit.ColorScheme.Light;

                    try {
                        // Attempt MapKit JS v6 custom styling for water
                        if (mapkit.MapStyle) {
                            const style = new mapkit.MapStyle({
                                overrides: {
                                    water: {
                                        fillColor: waterColor
                                    }
                                }
                            });
                            
                            if (mapkit.StandardMapConfiguration) {
                                this.map.configuration = new mapkit.StandardMapConfiguration({ style });
                            } else if (this.map.configuration) {
                                this.map.configuration.style = style;
                            }
                        }
                    } catch (e) {
                        console.warn('MapKit custom styling failed:', e);
                    }
                };

                // Initialize map
                const isDarkInitial = document.documentElement.classList.contains('dark');
                
                this.map = new mapkit.Map(el, {
                    colorScheme: isDarkInitial ? mapkit.ColorScheme.Dark : mapkit.ColorScheme.Light,
                    showsPointsOfInterest: false,
                    showsMapTypeControl: false,
                    showsZoomControl: false,
                    showsCompass: mapkit.FeatureVisibility.Hidden,
                    showsUserLocationControl: false,
                    showsUserLocation: false,
                    padding: new mapkit.Padding(20, 20, 20, 20)
                });

                this.applyThemeStyles(isDarkInitial);

                // Watch for theme changes from the parent Alpine scope
                this.$watch('darkMode', (val) => {
                    this.applyThemeStyles(val);
                });

                // Custom marker appearance
                this.allAnnotations = (points || []).map(point => {
                    const coordinate = new mapkit.Coordinate(point.lat, point.lng);
                    
                    const isSignee = point.type === 'signee';
                    
                    const annotation = new mapkit.MarkerAnnotation(coordinate, {
                        title: isSignee ? point.name : (point.city ? `${point.city}, ${point.state || ''}` : 'Global Visitor'),
                        subtitle: isSignee ? (point.message || 'Thanks for stopping by!') : 'Recently active on the site.',
                        color: isSignee ? "#82aaff" : "#c3e88d",
                        glyphText: "●",
                        displayPriority: isSignee ? mapkit.Annotation.DisplayPriority.High : mapkit.Annotation.DisplayPriority.Low
                    });
                    
                    annotation.data = point;
                    
                    return annotation;
                });

                this.updateVisibleAnnotations();

                // Tight zoom around continents/markers
                if (this.allAnnotations.length > 0) {
                    this.map.showItems(this.allAnnotations, {
                        animate: true,
                        padding: new mapkit.Padding(100, 40, 100, 40)
                    });
                } else {
                    // Default tight global view
                    this.map.region = new mapkit.CoordinateRegion(
                        new mapkit.Coordinate(20, 0),
                        new mapkit.CoordinateSpan(90, 180)
                    );
                }

                // Handle resize
                this.observer = new ResizeObserver(() => {
                    // MapKit JS generally handles resize well internally
                });
                this.observer.observe(el);

            } catch (error) {
                console.error('Failed to initialize Apple MapKit:', error);
            }
        },

        toggleLayer(type) {
            if (type === 'signee') {
                this.showSignees = !this.showSignees;
            } else if (type === 'visitor') {
                this.showVisitors = !this.showVisitors;
            }
            this.updateVisibleAnnotations();
        },

        updateVisibleAnnotations() {
            if (!this.map) return;
            
            this.map.removeAnnotations(this.map.annotations);
            
            const visible = this.allAnnotations.filter(annotation => {
                const type = annotation.data.type;
                if (type === 'signee') return this.showSignees;
                if (type === 'visitor') return this.showVisitors;
                return true;
            });
            
            this.map.addAnnotations(visible);
        },

        destroy() {
            if (this.observer) this.observer.disconnect();
            if (this.map) {
                this.map.destroy();
                this.map = null;
            }
        }
    };
}
